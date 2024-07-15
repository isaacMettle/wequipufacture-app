<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Resources\PaymentResource;
use Illuminate\Support\Facades\Validator;
use Exception;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $payments = Payment::getAllPayment();
            return PaymentResource::collection($payments);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'Status' => 'Fail'
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Valider les données
        $validated = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ], [
            'client_id.required' => 'L\'ID du client est requis.',
            'client_id.exists' => 'L\'ID du client spécifié n\'existe pas.',
            'amount.required' => 'Le montant est requis.',
            'amount.numeric' => 'Le montant doit être numérique.',
            'date.required' => 'La date est requise.',
            'date.date' => 'La date doit être une date valide.',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        // Créer le paiement
        $payment = Payment::createPayment($validated->validated());

        return response()->json([
            'message' => 'Paiement créé avec succès',
            'payment' => new PaymentResource($payment),
            'Status' => 201
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ], [
            'client_id.required' => 'L\'ID du client est requis.',
            'client_id.exists' => 'L\'ID du client spécifié n\'existe pas.',
            'amount.required' => 'Le montant est requis.',
            'amount.numeric' => 'Le montant doit être numérique.',
            'date.required' => 'La date est requise.',
            'date.date' => 'La date doit être une date valide.',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        // Mettre à jour le paiement
        $payment = Payment::updatePayment($request);

        return response()->json([
            'message' => 'Paiement mis à jour avec succès',
            'payment' => new PaymentResource($payment),
            'Status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        try {
            $deleted = Payment::deletePayment($id);
            if ($deleted) {
                return response()->json([
                    'message' => 'Paiement supprimé avec succès',
                    'Status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'Aucun paiement trouvé avec cet ID',
                    'Status' => 'Fail'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'Status' => 'Fail'
            ]);
        }
    }
}
