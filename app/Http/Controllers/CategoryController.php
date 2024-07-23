<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Category::getAllCategory();
            $cat = CategoryResource::collection( $categories);
            return response()->json($cat);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(), 
                'Status'=> 'fail']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        $category = Category::createCategory($validated->validated());

        return response()->json([
            'message' => 'Catégorie créée avec succès',
            'category' => new CategoryResource($category),
            'Status' => 201
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        $category = Category::updateCategory(array_merge(['id' => $id], $validated->validated()));

        if ($category) {
            return response()->json([
                'message' => 'Catégorie mise à jour avec succès',
                'category' => new CategoryResource($category),
                'Status' => 200
            ]);
        } else {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        try {
            $deleted = Category::deleteCategory($id);
            if ($deleted) {
                return response()->json([
                    'message' => 'Catégorie supprimée avec succès',
                    'Status'=> 200
                ]);
            } else {
                return response()->json(['message' => 'Catégorie non trouvée'], 404);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
