<?php

namespace App\Http\Controllers;

use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Http\Resources\InvoiceItemResource;
use Illuminate\Support\Facades\Validator;
use Exception;

class InvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $invoiceItems = InvoiceItem::getAllInvoiceItem();
            if ($invoiceItems->isNotEmpty()) {
                return InvoiceItemResource::collection($invoiceItems)->response()->setStatusCode(200);
            } else {
                return response()->json(['message' => 'Aucun élément de facture trouvé'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Valider les données
        $validated = Validator::make($request->all(), [
            'invoice_id' => 'required|exists:invoices,id',
            'description' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric',
            'tva' => 'required|numeric',
            'quantity' => 'required|integer',
            'total' => 'required|numeric',
        ], [
            'invoice_id.required' => 'L\'ID de facture est requis.',
            'invoice_id.exists' => 'L\'ID de facture n\'existe pas.',
            'description.required' => 'La description est requise.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 255 caractères.',
            'prix_unitaire.required' => 'Le prix unitaire est requis.',
            'prix_unitaire.numeric' => 'Le prix unitaire doit être numérique.',
            'tva.required' => 'La TVA est requise.',
            'tva.numeric' => 'La TVA doit être numérique.',
            'quantity.required' => 'La quantité est requise.',
            'quantity.integer' => 'La quantité doit être un entier.',
            'total.required' => 'Le total est requis.',
            'total.numeric' => 'Le total doit être numérique.',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        // Créer l'élément de facture
        return InvoiceItem::CreateInvoiceItem($validated->validated());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceItem $invoiceItem)
    {
        // Valider les données
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:invoice_items,id',
            'description' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric',
            'tva' => 'required|numeric',
            'quantity' => 'required|integer',
            'total' => 'required|numeric',
        ], [
            'id.required' => 'L\'ID est requis.',
            'id.exists' => 'L\'ID spécifié n\'existe pas.',
            'description.required' => 'La description est requise.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 255 caractères.',
            'prix_unitaire.required' => 'Le prix unitaire est requis.',
            'prix_unitaire.numeric' => 'Le prix unitaire doit être numérique.',
            'tva.required' => 'La TVA est requise.',
            'tva.numeric' => 'La TVA doit être numérique.',
            'quantity.required' => 'La quantité est requise.',
            'quantity.integer' => 'La quantité doit être un entier.',
            'total.required' => 'Le total est requis.',
            'total.numeric' => 'Le total doit être numérique.',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        // Mettre à jour l'élément de facture
        return InvoiceItem::UpdateInvoiceItem($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $deleted = InvoiceItem::deleteInvoiceItem($id);
        return response()->json(['success' => $deleted]);
    }
}