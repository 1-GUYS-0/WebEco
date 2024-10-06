<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannersSeeder extends Seeder
{
    public function run()
    {
        DB::table('banners')->insert([
            [
                'title' => 'Summer Sale',
                'images_path' => 'storage/banner_images/slide1.jpg',
                'start_date' => '2024-06-01',
                'end_date' => '2024-12-30',
                'link_to' => 'https://example.com/summer-sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Naturel Beauty',
                'images_path' => 'storage/banner_images/slide2.jpg',
                'start_date' => '2023-12-01',
                'end_date' => '2024-12-31',
                'link_to' => 'https://example.com/winter-sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Winter Sale',
                'images_path' => 'storage/banner_images/slide2.jpg',
                'start_date' => '2024-12-01',
                'end_date' => '2024-12-31',
                'link_to' => 'https://example.com/winter-sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}