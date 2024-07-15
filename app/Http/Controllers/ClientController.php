<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = Client::getAllClient();
        return ClientResource::collection($client);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'NIF' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
        ]);

        // Créer le client
        return Client::CreateClient($validated);
    }

    // Les autres méthodes du contrôleur...

    public function update(Request $request, Client $client)
    {
        Client::UpdateClient($request);
    }

    public function delete($id) {
        $deleted = Client::deleteClient($id);
        return response()->json(['success' => $deleted]);
    }
}
