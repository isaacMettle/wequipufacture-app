<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Resources\InvoiceResource;
use Illuminate\Support\Facades\Validator;
use Exception;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
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
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'total' => 'required|numeric',
            'statut' => 'required|string|in:payer,non payé',
            'approbation' => 'required|string|in:valide,non valide',
        ], [
            'client_id.required' => 'L\'ID du client est requis.',
            'client_id.exists' => 'Le client spécifié n\'existe pas.',
            'user_id.required' => 'L\'ID de l\'utilisateur est requis.',
            'user_id.exists' => 'L\'utilisateur spécifié n\'existe pas.',
            'date.required' => 'La date est requise.',
            'date.date' => 'La date doit être une date valide.',
            'total.required' => 'Le total est requis.',
            'total.numeric' => 'Le total doit être un nombre.',
            'statut.required' => 'Le statut est requis.',
            'statut.in' => 'Le statut doit être soit "payer" soit "non payé".',
            'approbation.required' => 'L\'approbation est requise.',
            'approbation.in' => 'L\'approbation doit être soit "valide" soit "non valide".',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        $invoice = Invoice::CreateInvoice($validated->validated());

        return response()->json([
            'message' => 'Facture créée avec succès',
            'invoice' => new InvoiceResource($invoice),
            'Status' => 201
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'total' => 'required|numeric',
            'statut' => 'required|string|in:payer,non payé',
            'approbation' => 'required|string|in:valide,non valide',
        ], [
            'client_id.required' => 'L\'ID du client est requis.',
            'client_id.exists' => 'Le client spécifié n\'existe pas.',
            'user_id.required' => 'L\'ID de l\'utilisateur est requis.',
            'user_id.exists' => 'L\'utilisateur spécifié n\'existe pas.',
            'date.required' => 'La date est requise.',
            'date.date' => 'La date doit être une date valide.',
            'total.required' => 'Le total est requis.',
            'total.numeric' => 'Le total doit être un nombre.',
            'statut.required' => 'Le statut est requis.',
            'statut.in' => 'Le statut doit être soit "payer" soit "non payé".',
            'approbation.required' => 'L\'approbation est requise.',
            'approbation.in' => 'L\'approbation doit être soit "valide" soit "non valide".',
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
}
