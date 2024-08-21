<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
{
    try {
        $creds = $request->validated();

        // Vérifier les informations d'identification pour les utilisateurs
        if (Auth::attempt($creds)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token', ['*'])->plainTextToken;

            return response()->json([
                'message' => 'Connexion réussie',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'status' => 'success',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->roles->pluck('name'),
                ],
            ]);
        }

        // Vérifier les informations d'identification pour les clients
        $client = Client::where('email', $creds['email'])->first();
        if ($client && Hash::check($creds['password'], $client->password)) {
            Auth::login($client);
            $token = $client->createToken('auth_token', ['*'])->plainTextToken;

            return response()->json([
                'message' => 'Client connecté',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'status' => 'success',
                'user' => [
                    'id' => $client->id,
                    'name' => $client->nom_clt,
                    'email' => $client->email,
                    'role' => $client->roles->pluck('name'),
                ],
            ]);
        }

        return response()->json([
            'message' => 'Email ou mot de passe invalide'
        ], 401);

    } catch (Exception $e) {
        return response()->json([
            'message' => $e->getMessage(),
            'status' => 'fail'
        ], 500);
    }
}

}