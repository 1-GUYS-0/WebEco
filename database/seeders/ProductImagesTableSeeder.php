<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert sample data
        DB::table('product_images')->insert([
            'image_path' => 'sample-image.jpg',
            'image_type' => 'thumbnail',
            'product_id' => 1, // Assuming product with ID 1 exists
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
