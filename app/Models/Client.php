<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Model {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'NIF',
        'email',
        'address',
    ];

    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = false;

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
        return Client::all();
    }

    public static function CreateClient($data)
    {
        $client = new self();
        $client->name = $data['name'];
        $client->NIF = $data['NIF'];
        $client->email = $data['email'];
        $client->address = $data['address'];
        $client->save();
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
