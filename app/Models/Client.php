<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;

class Client extends Model {
    use HasFactory, Notifiable , HasRoles, HasApiTokens;

    protected $fillable = [
        'name',
        'NIF',
        'email',
        'address',
        'password'
    ];

    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = false;

    protected $guard_name = 'web'; // ou le nom du guard que vous utilisez


    public function invoices() {
        return $this->hasMany(Invoice::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class);
    }

    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }

    public static function getAllClient() {
        return Client::orderBy('id','DESC')->get();
    }

    public static function CreateClient($data)
    {
        $client = new self();
        $client->name = $data['name'];
        $client->NIF = $data['NIF'];
        $client->email = $data['email'];
        $client->address = $data['address'];
        $client->password = bcrypt($data['password']);
        $client->save();
    
        // Assigner le rôle "Client" au nouvel utilisateur
        $client->assignRole('Client');
    
        return $client;
    }
    

    public static function UpdateClient($data)
    {
        $client = Client::find($data->id);
        $client->name = $data->name;
        $client->NIF = $data->NIF;
        $client->email = $data->email;
        $client->address = $data->address;
        $client->save();
        return $client;
    }

    public static function deleteClient($id) {
        $client = Client::find($id);
        if ($client) {
            $client->delete();
            return true;
        }
        return false;
    }
}
