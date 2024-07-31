<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use Exception;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       try{
        $roles = Role::getAllRoles();
        $rol= RoleResource::collection($roles);
        return response()->json($rol);
       }catch(Exception $e) {
        return response()->json([
            'message' => $e->getMessage(),
            'Status' => 'Fail'
        ]);
       }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return  Role::CreateRole($request);
    }

    public function update(Request $request, Role $role)
    {
        Role::updateRole($request);
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
    

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id) {
        $deleted = Role::deleteRole($id);
        return response()->json(['success' => $deleted]);
    }

    public function assignPermission(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissionId = $request->input('permission_id');

        $role->permissions()->attach($permissionId);

        return redirect()->back()->with('success', 'Permission assigned successfully.');
    }
}
