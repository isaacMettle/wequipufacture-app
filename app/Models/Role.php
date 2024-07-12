<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Role extends Model {
    use HasFactory, Notifiable;

    protected $fillable = [
        
        'name',
        
    ];

    protected $table='roles';

    protected $primaryKey='id';

    protected $keytype='int';

    public $timestamp=false;
    public function users() {
        return $this->hasMany(User::class);
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    public static function getAllrole(){

        return Role::all();
    }

    public static function CreateRole($data)
    {
        $role=new Self();
        $role->name=$data->name;
        $role->save();
    }
}
