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
        /*'category_id',*/
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
        return Product::all();
    }

    public static function CreateProduct($data)
    {
        $pdt = new self();
        $pdt->name = $data['name'];
        $pdt->description = $data['description'];
        $pdt->price = $data['price'];
    //    $pdt->category_id = $data['category_id'];
        $pdt->save();

        //return $pdt;
    }

    public static function UpdateProduct($data) {
        $pdt = self::find($data['id']);
        $pdt->name = $data['name'];
        $pdt->description = $data['description'];
        $pdt->price = $data['price'];
        /*$pdt->category_id = $data['category_id'];*/
        $pdt->save();
    }   

    public static function deleteProduct($id) {
        $product = self::find($id);
        if ($product) {
            $product->delete();
            return true;
        }
        return false;
    }
}
