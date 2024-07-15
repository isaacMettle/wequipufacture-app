<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
    ];

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = false; // Correction: timestamps avec 's'

    public function products() {
        return $this->hasMany(Product::class);
    }

    public static function getAllCategory() {
        return Category::all();
    }

    public static function createCategory($data) {
        $category = new self();
        $category->name = $data['name'];
        $category->save();
        return $category;
    }

    public static function updateCategory($data) {
        $category = Category::find($data['id']);
        $category->name = $data['name'];
        $category->save();
        return $category;
    }

    public static function deleteCategory($id) {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return true;
        }
        return false;
    }
}
