<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;


    class SubscriptionFactory extends Factory
    {
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition()
        {
            $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
            $endDate = (clone $startDate)->modify('+1 month');
    
            return [
                'client_id' => Client::inRandomOrder()->first()?->id,
                'product_id' => Product::inRandomOrder()->first()?->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'price' => $this->faker->randomFloat(2, 50, 500),
                'status' => $this->faker->randomElement(['active', 'cancelled']),
            ];
        }
    }
    

