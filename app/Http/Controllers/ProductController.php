<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::getAllProduct();
            return ProductResource::collection($products);
        } catch (Exception $e) {
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
        // Valider les données
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'description.required' => 'La description est requise.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 255 caractères.',
            'price.required' => 'Le prix est requis.',
            'price.numeric' => 'Le prix doit être numérique.',
            'category_id.required' => 'L\'ID de la catégorie est requis.',
            'category_id.exists' => 'L\'ID de la catégorie spécifiée n\'existe pas.',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        // Créer le produit
        $product = Product::CreateProduct($validated->validated());

        return response()->json([
            'message' => 'Produit créé avec succès',
            'product' => new ProductResource($product),
            'Status' => 201
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = Validator::make($request->all(), [
            'id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ], [
            'id.required' => 'L\'ID est requis.',
            'id.exists' => 'L\'ID spécifié n\'existe pas.',
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'description.required' => 'La description est requise.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 255 caractères.',
            'price.required' => 'Le prix est requis.',
            'price.numeric' => 'Le prix doit être numérique.',
            'category_id.required' => 'L\'ID de la catégorie est requis.',
            'category_id.exists' => 'L\'ID de la catégorie spécifiée n\'existe pas.',
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        // Mettre à jour le produit
        $product = Product::UpdateProduct($validated->validated());

        return response()->json([
            'message' => 'Produit mis à jour avec succès',
            'product' => new ProductResource($product),
            'Status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        try {
            $deleted = Product::deleteProduct($id);
            if ($deleted) {
                return response()->json([
                    'message' => 'Produit supprimé avec succès',
                    'Status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'Aucun produit trouvé avec cet ID',
                    'Status' => 'Fail'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'Status' => 'Fail'
            ]);
        }
    }
}
