<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Resources\InvoiceResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Exception;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $list=Invoice::getAllInvoice ();
            if($list->isNotEmpty()){
                $resp = InvoiceResource::collection($list);
                return response()->json($resp);
            }else{
                return response()->json(['message' => 'Aucune facture']);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'Status' => 'Fail'
            ], );
        }
       /* try {
            // Valider les données si nécessaire
            $validated = $request->validate([
                'limit' => 'sometimes|integer|min:1|max:100',
            ]);

            // Récupérer les factures avec une limite optionnelle
            $limit = $request->input('limit', 10); // Valeur par défaut de 10 si non spécifiée
            $invoices = Invoice::query()->take($limit)->get();

            if ($invoices->isNotEmpty()) {
                return InvoiceResource::collection($invoices)->response()->setStatusCode(200);
            } else {
                return response()->json(['message' => 'Aucune facture trouvée'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }*/
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

    public function getInvoiceInvoice_itemClientInfo()
    {
        try {
            // Jointure des tables invoices, clients et invoice_items
            $data = DB::table('invoices')
                ->join('clients', 'invoices.client_id', '=', 'clients.id')
                ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
                ->select(
                    'clients.name as client_name',
                    'clients.email as client_email',
                    DB::raw('SUM(invoice_items.total) as total_price'),
                    'invoices.date as invoice_date'
                )
                ->groupBy('clients.name', 'clients.email', 'invoices.date')
                ->get();

            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
