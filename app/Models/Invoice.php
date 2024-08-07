<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;

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
        'sub_total',
        'discount',
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
        return Invoice::with('client')->orderBy('id', 'desc')->get();
    }

    public static function create($data)
{
    // Utiliser la méthode only pour extraire uniquement les champs nécessaires
    $data = collect($data)->only([
        'client_id', 'date', 'invoice_number', 
        'due_date', 'note', 'email_text', 'sub_total', 'total', 'discount'
    ])->toArray();

    // Définir les valeurs par défaut pour les champs optionnels
    $invoice = new self();
    $invoice->client_id = $data['client_id'];
    $invoice->date = $data['date'];
    $invoice->invoice_number = $data['invoice_number'];
    $invoice->due_date = $data['due_date'];
    $invoice->note = $data['note'] ?? null;
    $invoice->email_text = $data['email_text'] ?? null;
    $invoice->sub_total = $data['sub_total'] ?? 0;
    $invoice->total = $data['total'] ?? 0;
    $invoice->discount = $data['discount'] ?? 0;
    $invoice->save();

    return $invoice;
}


    public static function UpdateInvoice($data)
    {
        $data = collect($data)->only([
            'id', 'date', 'due_date', 'invoice_number', 'note', 'email_text', 'sub_total', 'total', 'discount'
        ])->toArray();
    
        $invoice = Invoice::find($data['id']);
        if ($invoice) {
            $invoice->date = $data['date'];
            $invoice->due_date = $data['due_date'];
            $invoice->invoice_number = $data['invoice_number'];
            $invoice->note = $data['note'] ?? null;
            $invoice->email_text = $data['email_text'] ?? null;
            $invoice->sub_total = $data['sub_total'] ?? 0;
            $invoice->total = $data['total'] ?? 0;
            $invoice->discount = $data['discount'] ?? 0;
            $invoice->save();
        }
    
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
