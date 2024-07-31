<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Role extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public static function getAllRoles()
    {
        return self::all();
    }

    public static function createRole($data)
    {
        $role = new self();
        $role->name = $data->name;
        $role->save();
    }

    public static function updateRole($data)
    {
        $role = self::find($data->id);
        $role->name = $data->name;
        $role->save();
        return $role;
    }

    public static function deleteRole($id)
    {
        $role = self::find($id);
        $role->delete();
    }
}
