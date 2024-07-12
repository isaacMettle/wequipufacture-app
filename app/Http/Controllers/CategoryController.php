<?php
namespace App\Models;
namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //fonction pour lister les categrrories 
        $categories = Category::getAllCategory();
        return CategoryResource::collection($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Category::CreateCategory($request);
        
    }

    public function update(Request $request, Category $category)
    {
        Category::UpdateCategory($request);
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
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
