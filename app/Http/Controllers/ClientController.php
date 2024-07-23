<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ClientController extends Controller
{
    public function index()
    {
        try {
            $list = Client::getAllClient();
            if ($list->isNotEmpty()) {
                $resp = ClientResource::collection($list);
                return response()->json($resp);
            } else {
                return response()->json(['message' => 'Aucun Enregistrement']);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'Status' => 'Fail'
            ]);
        }
    }

    public function create(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'NIF' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        $client = Client::CreateClient($validated->validated());

        return response()->json([
            'message' => 'Client enregistré avec succès',
            'client' => new ClientResource($client),
            'Status' => 201
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'NIF' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        $client = Client::find($id);
        if (!$client) {
            return response()->json(['message' => 'Client non trouvé'], 404);
        }

        $client->update($validated->validated());

        return response()->json([
            'message' => 'Client modifié avec succès',
            'client' => new ClientResource($client),
            'Status' => 200
        ]);
    }

    public function delete($id)
    {
        try {
            $deleted = Client::deleteClient($id);
            if ($deleted) {
                return response()->json([
                    'message' => 'Client supprimé avec succès',
                    'Status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'Aucun client trouvé avec cet ID',
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
