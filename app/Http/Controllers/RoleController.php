<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::getAllrole();
        return RoleResource::collection($roles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return  Role::CreateRole($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    /*public function store(Request $request)
    {
        //
    }*/

    /**
     * Display the specified resource.
     */
    /*public function show(Role $role)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    /*public function edit(Role $role)
    {
        //
    }*/

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
