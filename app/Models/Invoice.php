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
        'invoice_number',
        'due_date',
        'note',
        'email_text',
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

    public static function getAllInvoice () { 
        return Invoice::all();
    }

    public static function create($data)
{
    //dd($data); // Ajoutez ceci pour déboguer les données reçues
    $invoice = new self();
    $invoice->client_id = $data['client_id'];
    $invoice->date = $data['date'];
    $invoice->invoice_number = $data['invoice_number']; 
    $invoice->due_date = $data['due_date'];     
    $invoice->note = $data['note'];
    $invoice->email_text = $data['email_text'];
    $invoice->save();
    return $invoice;
}


    public static function UpdateInvoice($data)
    {
        $invoice = Invoice::find($data['id']);
      
        $invoice->date = $data['date'];
        $invoice->due_date = $data['due_date'];
        $invoice->invoice_number = $data['invoice_number']; 
        $invoice->note = $data['note'];
        $invoice->email_text = $data['email_text']; 
        $invoice->save();
        return $invoice;
    }

    public static function deleteInvoice($id) {
        $invoice = Invoice::find($id);
        if ($invoice) {
            $invoice->delete();
            return true;
        }
        return false;
    }
}
