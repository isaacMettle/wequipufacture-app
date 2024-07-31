<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $creds = Auth::attempt($request->only('email', 'password'));
        if (!$creds) {
            return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
        }
        else
        {
            $user = User::where('email', $request->email)->first();
            Auth::login($user);
            return response()->json(['message' => 'Connexion reussie', 'user' => $user]);
        }

        // $user = User::where('email', $request->email)->first();

        // if (!$user || !Hash::check($request->password, $user->password)) {
        //     return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
        // }

        // // Connexion réussie
        // Auth::login($user);

        // return response()->json(['message' => 'Connexion réussie', 'user' => $user]);
    }
}
