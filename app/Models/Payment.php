<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Payment extends Model {
    use HasFactory, Notifiable;

    protected $fillable = [
        'client_id', // Ajout de client_id ici
        'amount',
        'date',
    ];

    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $keytype = 'int';
    public $timestamps = true; // Note : Utilisation correcte de timestamps

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public static function getAllPayment() {
        return Payment::all();
    }

    public static function CreatePayment($data) {
        $payment = new Self();
        $payment->client_id = $data['client_id']; // Assure-toi que client_id est défini
        $payment->amount = $data['amount'];
        $payment->date = $data['date'];
        $payment->save();
    }

    public static function updatePayment($data)
    {
        $payment= Payment::find($data->id);
        $payment->client_id=$data->client_id;
        $payment->amount=$data->amount;
        $payment->date=$data->date;
        $payment->save();
        return $payment;
    }

    public static function deletePayment($id) {
        $payment = self::find($id);
        if ($payment) {
            $payment->delete();
            return true;
        }
        return false;
    }
}
