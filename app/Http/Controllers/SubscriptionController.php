<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Resources\SubscriptionResource;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = Subscription::getAllSubscription();
        return SubscriptionResource::collection($subscriptions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required|in:active,cancelled',
            'price' => 'required|numeric',
            'client_id' => 'required|exists:clients,id',
            'product_id' => 'required|exists:products,id',
        ]);

        // Créer l'abonnement
        return Subscription::createSubscription($validated);
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
    /*public function show(Subscription $subscription)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(Subscription $subscription)
    {
        //
    }*/

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
