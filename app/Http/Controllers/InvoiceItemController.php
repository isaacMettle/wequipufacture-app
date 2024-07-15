<?php

namespace App\Http\Controllers;

use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Http\Resources\InvoiceItemResource;

class InvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoiceItems = InvoiceItem::getAllInvoiceItem();
        return InvoiceItemResource::collection($invoiceItems);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric',
            'tva' => 'required|numeric',
            'invoice_id' => 'required|exists:invoices,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'total' => 'required|numeric',
           
        ]);

        // Créer l'élément de facture
        return InvoiceItem::CreateInvoiceItem($validated);
    }

    public function update(Request $request, InvoiceItem $invoiceItem)
    {
        InvoiceItem::UpdateInvoiceItem($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    /*public function store(Request $request)
    {
        //
    }*/

    /**
     * Display the specified resource.
     */
    /*public function show(InvoiceItem $invoiceItem)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(InvoiceItem $invoiceItem)
    {
        //
    }*/

    /**
     * Update the specified resource in storage.
     */
   

    /**
     * Remove the specified resource from storage.
     */
    

    public function delete($id) {
        $deleted = InvoiceItem::deleteInvoiceItem($id);
        return response()->json(['success' => $deleted]);
    }
}
