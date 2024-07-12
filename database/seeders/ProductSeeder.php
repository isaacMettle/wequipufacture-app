<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Générer 10 produits en utilisant la factory
        Product::factory()->count(10)->create();
    }
}
