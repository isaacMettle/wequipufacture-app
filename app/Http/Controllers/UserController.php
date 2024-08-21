<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Exception;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       try{
        $users = User::getAllUser();
        $use =UserResource::collection($users);
        return response()->json($use);
       }catch(Exception $e){
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
        Log::info('Données reçues pour la création d\'un utilisateur : ', $request->all());

    // Valider les données
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'role_id' => 'required|exists:roles,id',
    ]);

    Log::info('Données validées : ', $validatedData);

    // Création de l'utilisateur
    $user = new User();
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->password = bcrypt($validatedData['password']);
    $user->save();

    Log::info('Utilisateur créé : ', $user->toArray());

    // Assigner le rôle à l'utilisateur
    $role = Role::find($validatedData['role_id']);
    $user->assignRole($role);

    Log::info('Rôle assigné : ', $role->toArray());

    return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user], 201);
    }


    
    public function update(Request $request, User $user)
    {
        // Valider les données
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
           
        ], [
            'id.required' => 'L\'ID est requis.',
            'id.exists' => 'L\'ID spécifié n\'existe pas.',
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'email est requis.',
            'email.string' => 'L\'email doit être une chaîne de caractères.',
            'email.email' => 'L\'email doit être une adresse email valide.',
            'email.max' => 'L\'email ne doit pas dépasser 255 caractères.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit avoir au moins 8 caractères.',
          
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        // Mettre à jour l'utilisateur
        return User::updateUser($validated->validated());
    }

    public function delete($id)
    {
        $deleted = User::deleteUser($id);
        return response()->json(['success' => $deleted]);
    }

    public function assignRole(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $roleId = $request->input('role_id');

        $user->roles()->attach($roleId);

        return redirect()->back()->with('success', 'Role assigned successfully.');
    }
}
