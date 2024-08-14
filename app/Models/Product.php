<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Product extends Model {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'description', // Correction de 'desciption' à 'description'
        'price',
        'quantity',
        'total',
        'category_id',
    ];

    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = false; // Correction de 'timestamp' à 'timestamps'

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function items() {
        return $this->hasMany(InvoiceItem::class);
    }

    public function clients() {
        return $this->belongsToMany(Client::class);
    }

    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }

    public static function getAllProduct() {
        return Product::orderBy('id', 'DESC')->get();
    }

    public static function CreateProduct($data)
    {
        $pdt = new self();
        $pdt->name = $data['name'];
    
        // Vérifier si les champs 'quantity' et 'total' existent dans les données avant de les assigner
        $pdt->quantity = $data['quantity'] ?? null;
        $pdt->total = $data['total'] ?? null;
    
        // Assigner la description s'il existe ou la laisser null sinon
        $pdt->description = $data['description'] ?? null;
    
        $pdt->price = $data['price'];
        $pdt->category_id = $data['category_id'];
        $pdt->save();
    
        return $pdt;
    }
    

    public static function UpdateProduct($data) {
        $pdt = Product::find($data->id);
    
        // Mettre à jour uniquement si les champs sont fournis
        if (isset($data->name)) {
            $pdt->name = $data->name;
        }
    
        if (isset($data->quantity)) {
            $pdt->quantity = $data->quantity;
        }
    
        if (isset($data->total)) {
            $pdt->total = $data->total;
        }
    
        if (isset($data->description)) {
            $pdt->description = $data->description;
        }
    
        if (isset($data->price)) {
            $pdt->price = $data->price;
        }
    
        /*if (isset($data['category_id'])) {
            $pdt->category_id = $data['category_id'];
        }*/
    
        $pdt->save();
        return $pdt;
    }
    

    public static function deleteProduct($id) {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return true;
        }
        return false;
    }
}
