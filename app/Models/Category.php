<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Category extends Model {
    use HasFactory, Notifiable;

    protected $fillable=[
        'name',
    ];

    protected $table='categories';

    protected $primaryKey='id';

    protected $keytype='int';

    public $timestamp=false;

    public function products() {
        return $this->hasMany(Product::class);
    }

    public static function getAllCategory() {
        return Category::all();
    }


    public static function CreateCategory($data) 
    {
          
        $pdt=new self();
        $pdt->name=$data->name;
        $pdt->save();

    }

    public static function UpdateCategory($data) 
    {
          
        $pdt=Category::find($data->id);
        $pdt->name=$data->name;
        $pdt->save();

    }

}
