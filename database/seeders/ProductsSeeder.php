<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('promotions')->insert([
            [
                'name' => 'Summer Sale',
                'percent_promotion' => 20.00,
                'promotion_start' => Carbon::create(2024, 6, 1, 0, 0, 0),
                'promotion_end' => Carbon::create(2024, 6, 30, 23, 59, 59),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Winter Sale',
                'percent_promotion' => 30.00,
                'promotion_start' => Carbon::create(2024, 12, 1, 0, 0, 0),
                'promotion_end' => Carbon::create(2024, 12, 31, 23, 59, 59),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Black Friday',
                'percent_promotion' => 50.00,
                'promotion_start' => Carbon::create(2024, 11, 29, 0, 0, 0),
                'promotion_end' => Carbon::create(2024, 11, 29, 23, 59, 59),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        $productCsvFile = fopen(base_path("database/data/product_cocoon.csv"), "r");
        $firstProductLine = true;

        while (($productData = fgetcsv($productCsvFile, 2000, ",")) !== FALSE) {
            if (!$firstProductLine) {
                DB::table('products')->insert([
                    'name' => $productData[0],
                    'price' => (int) filter_var($productData[1], FILTER_SANITIZE_NUMBER_INT),
                    'description' => $productData[2],
                    'note' => $productData[3],
                    'smell' => $productData[4],
                    'texture' => $productData[5],
                    'htu' => $productData[6],
                    'ingredient' => $productData[7],
                    'main_ingredient' => $productData[8],
                    'skin' => $productData[9],
                    'categories_id' => $productData[10],
                    'type' => $productData[11],
                    'brand' => $productData[12],
                    'weight' => $productData[13],
                    'stock' => $productData[14],
                    'total_purchase_quantity' => $productData[15],
                    'total_rating' => null,
                    'promotion_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $firstProductLine = false;
        }

        fclose($productCsvFile);


    }
}