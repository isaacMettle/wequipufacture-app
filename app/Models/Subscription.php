<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subscription extends Model {
    use HasFactory, Notifiable;

    protected $fillable = [
        'start_date', 
        'end_date',
        'status',
        'price',
        'client_id',
        'product_id',
    ];

    protected $table = 'subscriptions';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = false; // Correction de 'timestamp' à 'timestamps'

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public static function getAllSubscription() {
        return Subscription::all();
    }

    public static function createSubscription($data) {
        $subscription = new self();
        $subscription->start_date = $data['start_date'];
        $subscription->end_date = $data['end_date'];
        $subscription->status = $data['status'];
        $subscription->price = $data['price'];
        $subscription->client_id = $data['client_id'];
        $subscription->product_id = $data['product_id'];
        $subscription->save();

        return $subscription;
    }
}
