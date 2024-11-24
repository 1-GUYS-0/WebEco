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
        $csvFile = fopen(base_path("database/data/product-images.csv"), "r");
        $firstline = true;
        $productImages = [];

        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                $productImages[] = [
                    'image_path' => $data[0],
                    'image_type' => $data[1],
                    'product_id' => $data[2],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            $firstline = false;
        }

        fclose($csvFile);

        DB::table('product_images')->insert($productImages);
    }
}
