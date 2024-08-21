<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use Spatie\Permission\Models\Role;
use Exception;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       try{

        $list = Role::all();
        return response()->json($list);
        
       }catch(Exception $e) {
    
        
       }
    }

    /**
     * Show the form for creating a new resource.
     */
    
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
   
}
