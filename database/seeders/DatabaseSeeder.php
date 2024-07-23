<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // \App\Models\User::factory(50)->create();
        // \App\Models\Client::factory(50)->create();
        // \App\Models\Product::factory(100)->create();
        // \App\Models\Invoice::factory(200)->create();
        // \App\Models\InvoiceItem::factory(500)->create();
        // \App\Models\Payment::factory(200)->create();
        //  \App\Models\Role::factory(10)->create();
          \App\Models\Subscription::factory(10)->create();

    }
}
