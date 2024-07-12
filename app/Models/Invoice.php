<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invoice extends Model {
    use HasFactory, Notifiable;

    protected $fillable = [
        'client_id',
        'user_id',
        'date',
        'total',
        'statut',        
        'approbation',
    ];

    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = false;

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(InvoiceItem::class);
    }

    public static function getAllInvoice() { 
        return Invoice::all();
    }

    public static function CreateInvoice($data)
    {
        $invoice = new self();
        $invoice->client_id = $data['client_id'];
        $invoice->user_id = $data['user_id'];
        $invoice->date = $data['date'];
        $invoice->total = $data['total'];
        $invoice->statut = $data['statut'];
        $invoice->approbation = $data['approbation'];
        $invoice->save();

        return $invoice;
    }

    public static function UpdateInvoice($data)
    {
        $invoice = self::find($data['id']);
        $invoice->client_id = $data['client_id'];
        $invoice->user_id = $data['user_id'];
        $invoice->date = $data['date'];
        $invoice->total = $data['total'];
        $invoice->statut = $data['statut'];
        $invoice->approbation = $data['approbation'];
        $invoice->save();
    }
}
