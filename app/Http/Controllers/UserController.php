<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::getAllUser();
        return UserResource::collection($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Créer l'utilisateur
        return User::createUser($validated);
    }

    public function update(Request $request, User $user)
    {
        User::updateUser($request);
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
    /*public function show(User $user)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(User $user)
    {
        //
    }*/

    /**
     * Update the specified resource in storage.
     */
  

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id) {
        $deleted = User::deleteClient($id);
        return response()->json(['success' => $deleted]);
    }
}
