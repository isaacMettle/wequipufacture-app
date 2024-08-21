<?php

namespace App\Http\Controllers;
use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function assignAdminRole()
    {
        $user = User::where('email', 'admin@example.com')->first();

        if ($user) {
            $role = Role::where('name', 'Admin')->first();
            $user->assignRole($role);

            return 'Role Admin assigned successfully!';
        }

        return 'User not found!';
    }
}
