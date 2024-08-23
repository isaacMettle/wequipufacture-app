<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Counter;
use Illuminate\Http\Request;
use App\Http\Resources\InvoiceResource;
use App\Models\InvoiceItem;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Mail\InvoiceMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use Exception;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $invoices=Invoice::getAllInvoice ();
        return response()->json([
            'invoices' => $invoices
        ],200);
   
    }

    public function getInvoicesWithClientInfo()
{
    try {
        // Join invoices with clients
        $data = DB::table('invoices')
            ->join('clients', 'invoices.client_id', '=', 'clients.id')
            ->select('invoices.id as invoice_id', 'clients.name as client_name', 'invoices.total', 'invoices.statut', 'invoices.date')
            ->get();

        return response()->json($data);
    } catch (Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

public function show($id){
    $invoice = Invoice::find($id);
    if ($invoice) {
        return new InvoiceResource($invoice);
    } else {
        return response()->json(['message' => 'Facture non trouvée'], 404);
    }
}


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Ajoutez ceci pour déboguer les données reçues
        //$data = $request->all();
       // Log::info('Request Data: ', $data);
    
        $validated = Validator::make($request->all(), [
            'client_id' => 'required|integer',
            'date' => 'required|date',
            'invoice_number' => 'required|string',
            'due_date' => 'required|date',            
            'note' => 'required|string',
            'email_text' => 'required|string',
           
        ], [
            'date.required' => 'La date est requise.',
            'date.date' => 'La date doit être une date valide.',
            'due_date.required' => 'La date d\'échéance est requise.',
            'due_date.date' => 'La date d\'échéance doit être une date valide.',
            'invoice_number.required' => 'Le numéro de facture est requis.',
            'invoice_number.string' => 'Le numéro de facture doit être valide.',
            'note.required' => 'La note est requise.',
            'note.string' => 'La note doit être valide.',
            'email_text.required' => 'Le texte de l\'email est requis.',
            'email_text.string' => 'Le texte de l\'email doit être valide.',
            'client_id.required' => 'Le client est requis.',
            'client_id.integer' => 'Le client doit être un ID valide.',
        ]);
    
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }
    
        $invoice = Invoice::create($validated->validated());
    
        return response()->json([
            'message' => 'Facture créée avec succès',
            'invoice' => new InvoiceResource($invoice),
            'Status' => 201
        ]);
    }
    

public function update(Request $request, Invoice $invoice)
{
    $validated = Validator::make($request->all(), [
        'date' => 'required|date',
        'due_date' => 'required|date',
        'note' => 'required|string',
        'email_text' => 'required|string',
    ], [
        'date.required' => 'La date est requise.',
        'date.date' => 'La date doit être une date valide.',
        'due_date.required' => 'La date d\'échéance est requise.',
        'due_date.date' => 'La date d\'échéance doit être une date valide.',
        'note.required' => 'La note est requise.',
        'email_text.required' => 'Le texte de l\'email est requis.',
    ]);

    if ($validated->fails()) {
        return response()->json(['errors' => $validated->errors()], 422);
    }

    $invoice = Invoice::UpdateInvoice($request);

    return response()->json([
        'message' => 'Facture mise à jour avec succès',
        'invoice' => new InvoiceResource($invoice),
        'Status' => 200
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        try {
            $deleted = Invoice::deleteInvoice($id);
            if ($deleted) {
                return response()->json([
                    'message' => 'Facture supprimée avec succès',
                    'Status'=> 200
                ]);
            } else {
                return response()->json(['message' => 'Facture non trouvée'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public static function getAllInvoice () { 
        return Invoice::with('client')->orderBy('id', 'desc')->get();
    }
   
    public function search_invoice(Request $request)
{
    $search = $request->get('s');
    if ($search != null) {
        // Assurez-vous que 'client' fait référence à une relation ou à une colonne appropriée
        $invoices = Invoice::whereHas('client', function($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->get();

        return response()->json([
            'invoices' => $invoices
        ], 200);
    } else {
        return $this->getAllInvoice();
    }
}


    public function create_invoice(Request $request){
        
        $counter= Counter::where('key','invoice')->first();
        $random = Counter::where('key','invoice')->first();


        $invoice=Invoice::orderBy('id','DESC')->first();

        if( $invoice){
            $invoice =  $invoice->id+1;
            $counters =  $counter->value+ $invoice;

        }else{
            $counters =  $counter->value;
        }

        $formData =[
            'invoice_number'=>$counter -> prefix.$counters,
            'client_id' => null,
            'client' => null,
            'date'=> date('Y-m-d'),
            'due_date'=> null,
            'discount'=> 0,
            'note'=> null,
            'email_text'=> 'voici votre facture', 

            'items'=> [
                [
                    'product_id'=>null,
                    'product'=>null,
                    'description'=>null,
                    'price'=> 0,
                    'quatity'=>1
                ]
            ]
        ];
        return response()->json($formData);
    }


    
    public function add_invoice(Request $request)
    {
        // Définir les règles de validation
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|integer|exists:clients,id',
            'date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:date',
            'note' => 'nullable|string',
            'sub_total' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'invoice_number' => 'required|string|unique:invoices,invoice_number',
            'invoice_item' => 'required|json',
        ]);
    
        // Vérifier si la validation échoue
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
    
        $invoiceItems = json_decode($request->input('invoice_item'), true); // Decode JSON string to array
    
        // Vérifier que chaque article contient les clés nécessaires
        foreach ($invoiceItems as $item) {
            if (!isset($item['product_id']) || !isset($item['price']) || !isset($item['quantity'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Each invoice item must contain product_id, price, and quantity.'
                ], 422);
            }
        }
    
        $invoiceData = $request->only([
            'client_id', 'date', 'due_date', 'note',
            'sub_total', 'total', 'discount', 'invoice_number'
        ]);
    
        $invoice = Invoice::create($invoiceData);
    
        foreach ($invoiceItems as $item) {
            $itemData = [
                'invoice_id' => $invoice->id,
                'product_id' => $item['product_id'],
                'prix_unitaire' => $item['price'],
                'quantity' => $item['quantity'],
            ];
    
            InvoiceItem::create($itemData);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Invoice created successfully.'
        ], 201);
    }
    
    public function show_invoice($id){
        $invoice = Invoice::with(['client','items.product'])->find($id);
        return response()->json([
            'invoice' => $invoice
        ],200);
    }


    public function edit_invoice($id){
        $invoice = Invoice::with(['client','items.product'])->find($id);
        return response()->json([
            'invoice' => $invoice
        ],200);
    }

    public function delete_invoice_items($id)
{
    try {
        // Vérifier si l'article existe
        $item = InvoiceItem::findOrFail($id);

        // Supprimer l'article
        $item->delete();

        return response()->json(['success' => true, 'message' => 'Article supprimé avec succès.'], 200);
    } catch (\Exception $e) {
        // Gérer les erreurs
        return response()->json(['error' => 'Erreur lors de la suppression de l\'article : ' . $e->getMessage()], 500);
    }
}

    public function updateApprobation(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'approbation' => 'required|in:en attente,approuver,non approuver',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Facture non trouvée'], 404);
        }

        $invoice->approbation = $request->approbation;
        $invoice->save();

        return response()->json([
            'message' => 'Approbation mise à jour avec succès',
            'invoice' => $invoice
        ], 200);
    }

  

    public function sendInvoice($invoiceId)
{
    $invoice = Invoice::with('items.product', 'client')->find($invoiceId);

    if ($invoice) {
        // Generate the PDF from the view
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        // Send the email with the PDF attached
        Mail::to($invoice->client->email)->send(new InvoiceMail($invoice, $pdf));

        return response()->json(['message' => 'Invoice sent successfully.']);
    }

    return response()->json(['message' => 'Invoice not found.'], 404);
}


public function dashboardStats()
    {
        // Nombre total de factures créées
        $totalInvoices = Invoice::count();

        // Nombre total de clients enregistrés
        $totalClients = Client::count();

        // Nombre total de factures envoyées
        $sentInvoices = Invoice::where('statut', 'envoyé')->count();

        // Total du revenu
        $totalRevenue = Invoice::sum('total');

        // Retourner les données en JSON
        return response()->json([
            'totalInvoices' => $totalInvoices,
            'totalClients' => $totalClients,
            'sentInvoices' => $sentInvoices,
            'totalRevenue' => $totalRevenue,
        ]);
    }
    

    public function updateStatus(Request $request, $id)
{
    $invoice = Invoice::findOrFail($id);
    $invoice->statut = $request->input('statut');
    $invoice->save();

    return response()->json(['message' => 'Status updated successfully']);
}

public function getRecentInvoices(Request $request)
{
    // Définir la limite optionnelle pour le nombre de factures à récupérer
    $limit = $request->input('limit', 10); // Par défaut, on récupère 10 factures

    // Récupérer les factures récentes avec les informations du client
    $recentInvoices = Invoice::with('client') // Assuming 'client' is the relationship method in Invoice model
                            ->orderBy('date', 'desc')
                            ->take($limit)
                            ->get();

    // Retourner les factures avec les informations du client sous forme de JSON
    return response()->json([
        'recentInvoices' => $recentInvoices
    ], 200);
}

public function modifier_invoice(Request $request, $id) {
    try {
        // Valider les données reçues
        $request->validate([
            'sub_total' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'client_id' => 'nullable|integer',
            'invoice_number' => 'nullable|string',
            'date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'discount' => 'nullable|numeric',
            'note' => 'nullable|string',
            'email_text' => 'nullable|string',
            'invoice_item' => 'nullable|json'
        ]);

        // Trouver la facture par ID
        $invoice = Invoice::findOrFail($id);

        // Mettre à jour les champs seulement s'ils sont fournis
        if ($request->has('sub_total')) {
            $invoice->sub_total = $request->sub_total;
        }
        if ($request->has('total')) {
            $invoice->total = $request->total;
        }
        if ($request->has('client_id')) {
            $invoice->client_id = $request->client_id;
        }
        if ($request->has('invoice_number')) {
            $invoice->invoice_number = $request->invoice_number;
        }
        if ($request->has('date')) {
            $invoice->date = $request->date;
        }
        if ($request->has('due_date')) {
            $invoice->due_date = $request->due_date;
        }
        if ($request->has('discount')) {
            $invoice->discount = $request->discount;
        }
        if ($request->has('note')) {
            $invoice->note = $request->note;
        }
        if ($request->has('email_text')) {
            $invoice->email_text = $request->email_text;
        }

        // Sauvegarder les modifications
        $invoice->save();

        // Supprimer les anciens articles de facture
        $invoice->items()->delete();

        // Si des articles sont fournis dans la requête
        if ($request->has('invoice_item')) {
            $invoiceitems = $request->input('invoice_item');
            $decodedItems = json_decode($invoiceitems);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json(['error' => 'Erreur de décodage JSON : ' . json_last_error_msg()], 400);
            }

            if (is_array($decodedItems) || is_object($decodedItems)) {
                foreach ($decodedItems as $item) {
                    if (!isset($item->product_id, $item->price, $item->quantity)) {
                        return response()->json(['error' => 'Données d\'article invalides.'], 400);
                    }

                    $itemData = [
                        'invoice_id' => $invoice->id,
                        'product_id' => $item->product_id,
                        'prix_unitaire' => $item->price,
                        'quantity' => $item->quantity,
                    ];

                    InvoiceItem::create($itemData);
                }
            } else {
                return response()->json(['error' => 'Aucun article trouvé pour cette facture.'], 400);
            }
        }

        return response()->json(['message' => 'Facture mise à jour avec succès.'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur serveur : ' . $e->getMessage()], 500);
    }
}




    
}
