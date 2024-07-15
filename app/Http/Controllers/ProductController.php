<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::getAllProduct();
        return ProductResource::collection($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Créer le produit
        return Product::CreateProduct($validated);
    }
    public function update(Request $request, Product $product)
    {
        Product::UpdateProduct($request);
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
    /*public function show(Product $product)
    {
        //
    }*/

    /**
     * Show the form for editing the specified resource.
     */
    /* public function edit(Product $product)
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
        $deleted = Product::deleteProduct($id);
        return response()->json(['success' => $deleted]);
    }
}
