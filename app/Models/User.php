<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Ajouté pour permettre l'assignation de role_id
    ];

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true; // Correction de 'timestamp' à 'timestamps'

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function invoices() {
        return $this->hasMany(Invoice::class);
    }

    public static function getAllUser() {
        return User::all();
    }

    public static function createUser($data) {
        $user = new self();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']); // Hashage du mot de passe
        $user->role_id = $data['role_id']; // Ajouté pour lier le rôle
        $user->save();

        return $user;
    }
}
