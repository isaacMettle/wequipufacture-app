<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class InvoiceItem extends Model {
    use HasFactory, Notifiable;

    protected $fillable = [
        'description',
        'prix_unitaire',
        'tva',
        'invoice_id',
        'product_id',        
        'quantity',
        'total',
       
    ];

    protected $table = 'invoice_items';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = false; // Correction de 'timestamp' à 'timestamps'

    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public static function getAllInvoiceItem() {
        return InvoiceItem::all();
    }

    public static function CreateInvoiceItem($data) {
        $pdt = new self();
        $pdt->description = $data['description'];
        $pdt->prix_unitaire = $data['prix_unitaire'];
        $pdt->tva = $data['tva'];
        $pdt->invoice_id = $data['invoice_id'];
        $pdt->product_id = $data['product_id'];
        $pdt->quantity = $data['quantity'];
        $pdt->total = $data['total'];
        $pdt->save();

        return $pdt;
    }

    public static function UpdateInvoiceItem($data) {
        $pdt = self::find($data['id']);
        $pdt->description = $data['description'];
        $pdt->prix_unitaire = $data['prix_unitaire'];
        $pdt->tva = $data['tva'];
        $pdt->invoice_id = $data['invoice_id'];
        $pdt->product_id = $data['product_id'];
        $pdt->quantity = $data['quantity'];
        $pdt->total = $data['total'];
        $pdt->save();
    }

    public static function deleteInvoiceItem($id) {
        $invoiceItem = self::find($id);
        if ($invoiceItem) {
            $invoiceItem->delete();
            return true;
        }
        return false;
    }
}
