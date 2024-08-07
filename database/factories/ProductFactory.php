<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'item_code' => 'IC-'.$this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(100, 1000),
            'category_id' => Category::inRandomOrder()->first()?->id ?? function() {
                return Category::factory()->create()->id;
            },
        ];
    }
}
