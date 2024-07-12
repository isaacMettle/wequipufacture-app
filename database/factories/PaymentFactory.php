<?php

namespace Database\Factories;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       
        return [
          'client_id' => Client::inRandomOrder()->first()->id,
          'amount' => fake()->randomFloat(2, 50, 500),
          'date' => fake()->date(),
        ];
    }
}
