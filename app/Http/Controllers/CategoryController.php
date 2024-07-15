<?php
namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        // Fonction pour lister les catégories
        
        $categories = Category::getAllCategory();
        return CategoryResource::collection($categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::createCategory($validated);
        return response()->json($category);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::updateCategory(array_merge(['id' => $id], $validated));
        return response()->json($category);
    }

    public function delete($id) {
        $deleted = Category::deleteCategory($id);
        return response()->json(['success' => $deleted]);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request) {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    // public function show(Category $category) {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Category $category) {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Category $category) {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Category $category) {
    //     //
    // }
}
