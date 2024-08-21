<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;

class User extends Authenticatable {
    use HasFactory, Notifiable , HasRoles, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        //'role_id'
        // Ajouté pour permettre l'assignation de role_id
    ];

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true; // Correction de 'timestamp' à 'timestamps'

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function permissions()
    {
        return $this->role->permissions();
    }

    public function hasPermission($permission)
    {
        return $this->permissions()->where('name', $permission)->exists();
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
        $user->password = bcrypt($data['password']);
        $user->save();
    
        // Assigner le rôle à l'utilisateur
        $role = Role::find($data['role_id']);
        if ($role) {
            $user->assignRole($role);
        }
    
        return $user;
    }
    
    

    public static function updateUser($data){
        $user = User::find($data->id);
        $user->name = $data->name;
        $user->email = $data->email;
        $user->password = bcrypt($data->password);
     
        $user->save();
        return $user;
    }

    public static function deleteUser($id) {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }
}
