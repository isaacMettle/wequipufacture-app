<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payment = Payment::getAllPayment();
        return PaymentResource::collection($payment);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id', // Validation de l'ID client
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        // Créer le paiement
        return Payment::CreatePayment($validated);
    }

    public function update(Request $request, Payment $payment)
    {
        Payment::updatePayment($request);
    }

    public function delete($id) {
        $deleted = Payment::deletePayment($id);
        return response()->json(['success' => $deleted]);
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
    /*public function show(Payment $payment)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(Payment $payment)
    {
        //
    }*/

    /**
     * Update the specified resource in storage.
     */
 

    /**
     * Remove the specified resource from storage.
     */
    /*public function destroy(Payment $payment)
    {
        //
    }*/
}
