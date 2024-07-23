<?php

namespace Database\Factories;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Invoice;
use App\Models\Product;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
            'description' => $this->faker->sentence(), // Génère une phrase aléatoire
            'prix_unitaire' => $this->faker->randomFloat(2, 10, 100), // Génère un float avec 2 décimales entre 10 et 100
            'tva' => $this->faker->randomFloat(2, 0, 20), // Génère un float avec 2 décimales entre 0 et 20
            'quantity' => $this->faker->numberBetween(1, 10), // Génère un nombre entre 1 et 10
            'total' => $this->faker->randomFloat(2, 10, 100), // Génère un float avec 2 décimales entre 10 et 100
        ];
    }
    
    
}
