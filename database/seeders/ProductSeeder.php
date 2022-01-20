<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'sku' => 'SKU01',
                'price' => 125.50,
            ],
            [
                'sku' => 'SKU02',
                'price' => 210.00,
            ],
            [
                'sku' => 'SKU03',
                'price' => 50.00,
            ]
        ];

        foreach( $products as $product ) {
            Product::create($product);
        }
    }
}
