<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition()
    {
        return [
            'client_id' => Client::inRandomOrder()->first()?->id,
            'user_id' => User::inRandomOrder()->first()?->id,
            'date' => $this->faker->date(),
            'total' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}
