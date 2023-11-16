<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'name' => 'Ürün 1',
            'description' => 'Bu ürünün açıklaması.',
            'price' => 19.99,
        ]);

        Product::create([
            'name' => 'Ürün 2',
            'description' => 'Bu ürünün başka bir açıklaması.',
            'price' => 29.99,
        ]);

        Product::create([
            'name' => 'Ürün 3',
            'description' => 'Bu ürünün başka bir açıklaması.',
            'price' => 39.99,
        ]);

        Product::create([
            'name' => 'Ürün 4',
            'description' => 'Bu ürünün başka bir açıklaması.',
            'price' => 49.99,
        ]);

        Product::create([
            'name' => 'Ürün 5',
            'description' => 'Bu ürünün başka bir açıklaması.',
            'price' => 59.99,
        ]);
    }
}
