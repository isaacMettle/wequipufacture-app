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
        'quantity' => fake()->numberBetween(1, 10),
        'total' => fake()->randomFloat(2, 10, 100),
        ];
    }
}
