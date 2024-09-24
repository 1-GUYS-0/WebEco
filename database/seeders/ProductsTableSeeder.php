<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'name' => 'Sample Product',
            'price' => 99.99,
            'description' => 'This is a sample product description.',
            'smell' => 'Floral',
            'texture' => 'Smooth',
            'htu' => 'Apply gently on skin.',
            'ingredient' => 'Water, Glycerin, Fragrance',
            'main_ingredient' => 'Glycerin',
            'skin' => 'All types',
            'stock' => 100,
            'categories_id' => 1, // Assuming category with ID 1 exists
            'total_rating' => 4.5,
            'total_purchase_quantity' => 50,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
