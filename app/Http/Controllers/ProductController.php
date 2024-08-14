<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::getAllProduct();
            $prod = ProductResource::collection($products);
            return response()->json($prod);

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
            'quantity'  => 'nullable|numeric', // Définir comme nullable
            'total' => 'nullable|numeric',     // Définir comme nullable
            'description' => 'nullable|string|max:255', // Définir comme nullable
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ], );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        // Créer le produit
        $product = Product::CreateProduct($validated->validated());

        return response()->json([
            'message' => 'Produit créé avec succès',
            'product' => $product,
            'Status' => 201
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }
    
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'quantity' => 'nullable|numeric',
            'total' => 'nullable|numeric',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric',
        ]);
    
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }
    
        Log::info('Validated data: ', $validated->validated());
    
        // Mettre à jour le produit
        $product->update($validated->validated());
    
        Log::info('Updated product: ', $product->toArray());
    
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

    public function getProductsWithCategoryInfo()
    {
        try {
            // Join invoices with clients
            $data = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('products.id as product_id', 'categories.name as category_name', 'products.name', 'products.description', 'products.price')
                ->get();
    
            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
