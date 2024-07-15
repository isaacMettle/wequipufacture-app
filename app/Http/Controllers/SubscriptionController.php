<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Resources\SubscriptionResource;
use Illuminate\Support\Facades\Validator;
use Exception;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $subscriptions = Subscription::getAllSubscription();
            return SubscriptionResource::collection($subscriptions);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'Status'=> 'Fail'
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
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|in:active,cancelled',
            'price' => 'required|numeric',
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'required|exists:products,id',
        ], [
            'start_date.required' => 'La date de début est requise.',
            'start_date.date' => 'La date de début doit être une date valide.',
            'end_date.required' => 'La date de fin est requise.',
            'end_date.date' => 'La date de fin doit être une date valide.',
            'status.required' => 'Le statut est requis.',
            'status.in' => 'Le statut doit être soit "active" soit "cancelled".',
            'price.required' => 'Le prix est requis.',
            'price.numeric' => 'Le prix doit être numérique.',
            'client_id.required' => 'L\'ID du client est requis.',
            'client_id.exists' => 'L\'ID du client spécifié n\'existe pas.',
            'product_id.required' => 'L\'ID du produit est requis.',
            'product_id.exists' => 'L\'ID du produit spécifié n\'existe pas.',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        // Créer l'abonnement
        return Subscription::createSubscription($validated->validated());
    }

    public function update(Request $request, Subscription $subscription)
    {
        // Valider les données
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:subscriptions,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|in:active,cancelled',
            'price' => 'required|numeric',
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'required|exists:products,id',
        ], [
            'id.required' => 'L\'ID est requis.',
            'id.exists' => 'L\'ID spécifié n\'existe pas.',
            'start_date.required' => 'La date de début est requise.',
            'start_date.date' => 'La date de début doit être une date valide.',
            'end_date.required' => 'La date de fin est requise.',
            'end_date.date' => 'La date de fin doit être une date valide.',
            'status.required' => 'Le statut est requis.',
            'status.in' => 'Le statut doit être soit "active" soit "cancelled".',
            'price.required' => 'Le prix est requis.',
            'price.numeric' => 'Le prix doit être numérique.',
            'client_id.required' => 'L\'ID du client est requis.',
            'client_id.exists' => 'L\'ID du client spécifié n\'existe pas.',
            'product_id.required' => 'L\'ID du produit est requis.',
            'product_id.exists' => 'L\'ID du produit spécifié n\'existe pas.',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        // Mettre à jour l'abonnement
        return Subscription::updatedSubscription($validated->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $deleted = Subscription::deleteSubscription($id);
        return response()->json(['success' => $deleted]);
    }
}
