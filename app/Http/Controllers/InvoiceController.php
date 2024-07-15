<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Resources\InvoiceResource;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoice = Invoice::getAllInvoice();
        return InvoiceResource::collection($invoice);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'total' => 'required|numeric',
            'statut' => 'required|string|in:payer,non payé',
            'approbation' => 'required|string|in:valide,non valide',
        ]);

        // Créer la facture
        return Invoice::CreateInvoice($validated);
    }

    // Les autres méthodes du contrôleur...

    public function update(Request $request, Invoice $invoice)
    {
        Invoice::UpdateInvoice($request);
    }

    public function delete($id) {
        $deleted = Invoice::deleteInvoice($id);
        return response()->json(['success' => $deleted]);
    }
}
