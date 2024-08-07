<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class UpdateProductItemCodes extends Command
{
    protected $signature = 'products:update-item-codes';
    protected $description = 'Update item codes for existing products';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $product->item_code = 'ITEM-' . $product->id;
            $product->save();
        }

        $this->info('Item codes updated successfully.');
    }
}
