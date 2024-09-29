<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert sample data
        $productImages = [
            [
                'image_path' => '/product_images/sp1-1.jpg',
                'image_type' => 'thumbnail',
                'product_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => '/product_images/sp1-2.jpg',
                'image_type' => 'gallery',
                'product_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => '/product_images/sp2-1.jpg',
                'image_type' => 'thumbnail',
                'product_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => '/product_images/sp2-2.jpg',
                'image_type' => 'gallery',
                'product_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => '/product_images/sp3-1.jpg',
                'image_type' => 'thumbnail',
                'product_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => '/product_images/sp3-2.jpg',
                'image_type' => 'gallery',
                'product_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => '/product_images/sp1-2.jpg',
                'image_type' => 'thumbnail',
                'product_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => '/product_images/sp2-2.jpg',
                'image_type' => 'gallery',
                'product_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'image_path' => '/product_images/sp3-2.jpg',
                'image_type' => 'gallery',
                'product_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('product_images')->insert($productImages);
    }
}
