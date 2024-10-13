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
        $products = [
            [
                'name' => 'Sản phẩm chăm sóc da',
                'brand' => 'Brand 1',
                'weight' => '100ml',
                'price' => 100000,
                'description' => 'Mô tả sản phẩm chăm sóc da',
                'smell' => 'Hương thơm dịu nhẹ',
                'texture' => 'Dạng kem',
                'htu' => 'Hướng dẫn sử dụng sản phẩm chăm sóc da',
                'ingredient' => 'Thành phần sản phẩm chăm sóc da',
                'main_ingredient' => 'Thành phần chính sản phẩm chăm sóc da',
                'skin' => 'Mọi loại da',
                'stock' => 50,
                'categories_id' => 1, // Chăm sóc da
                'total_rating' => 4.5,
                'total_purchase_quantity' => 100,
                'note' => 'Ghi chú sản phẩm chăm sóc da',
                'promotion_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sản phẩm chăm sóc tóc',
                'brand' => 'Brand 2',
                'weight' => '200ml',
                'price' => 150000,
                'description' => 'Mô tả sản phẩm chăm sóc tóc',
                'smell' => 'Hương thơm tươi mát',
                'texture' => 'Dạng dầu gội',
                'htu' => 'Hướng dẫn sử dụng sản phẩm chăm sóc tóc',
                'ingredient' => 'Thành phần sản phẩm chăm sóc tóc',
                'main_ingredient' => 'Thành phần chính sản phẩm chăm sóc tóc',
                'skin' => 'Mọi loại tóc',
                'stock' => 30,
                'categories_id' => 2, // Chăm sóc tóc
                'total_rating' => 4.7,
                'total_purchase_quantity' => 200,
                'note' => 'Ghi chú sản phẩm chăm sóc tóc',
                'promotion_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sản phẩm tắm và dưỡng thể',
                'brand' => 'Brand 1',
                'weight' => '300ml',
                'price' => 200000,
                'description' => 'Mô tả sản phẩm tắm và dưỡng thể',
                'smell' => 'Hương thơm quyến rũ',
                'texture' => 'Dạng sữa tắm',
                'htu' => 'Hướng dẫn sử dụng sản phẩm tắm và dưỡng thể',
                'ingredient' => 'Thành phần sản phẩm tắm và dưỡng thể',
                'main_ingredient' => 'Thành phần chính sản phẩm tắm và dưỡng thể',
                'skin' => 'Mọi loại da',
                'stock' => 40,
                'categories_id' => 3, // Tắm và Dưỡng thể
                'total_rating' => 4.8,
                'total_purchase_quantity' => 150,
                'note' => 'Ghi chú sản phẩm tắm và dưỡng thể',
                'promotion_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sản phẩm chăm sóc da new',
                'brand' => 'Brand 2',
                'weight' => '50ml',
                'price' => 100000,
                'description' => 'Mô tả sản phẩm chăm sóc da',
                'smell' => 'Hương thơm dịu nhẹ',
                'texture' => 'Dạng kem',
                'htu' => 'Hướng dẫn sử dụng sản phẩm chăm sóc da',
                'ingredient' => 'Thành phần sản phẩm chăm sóc da',
                'main_ingredient' => 'Thành phần chính sản phẩm chăm sóc da',
                'skin' => 'Mọi loại da',
                'stock' => 10,
                'categories_id' => 1, // Chăm sóc da
                'total_rating' => 4.5,
                'total_purchase_quantity' => 100,
                'note' => 'Ghi chú sản phẩm chăm sóc da',
                'promotion_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sản phẩm chăm sóc tóc new',
                'brand' => 'Brand 1',
                'weight' => '150ml',
                'price' => 150000,
                'description' => 'Mô tả sản phẩm chăm sóc tóc',
                'smell' => 'Hương thơm tươi mát',
                'texture' => 'Dạng dầu gội',
                'htu' => 'Hướng dẫn sử dụng sản phẩm chăm sóc tóc',
                'ingredient' => 'Thành phần sản phẩm chăm sóc tóc',
                'main_ingredient' => 'Thành phần chính sản phẩm chăm sóc tóc',
                'skin' => 'Mọi loại tóc',
                'stock' => 4,
                'categories_id' => 2, // Chăm sóc tóc
                'total_rating' => 4.7,
                'total_purchase_quantity' => 200,
                'note' => 'Ghi chú sản phẩm chăm sóc tóc',
                'promotion_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sản phẩm tắm và dưỡng thể new',
                'brand' => 'Brand 2',
                'weight' => '250ml',
                'price' => 200000,
                'description' => 'Mô tả sản phẩm tắm và dưỡng thể',
                'smell' => 'Hương thơm quyến rũ',
                'texture' => 'Dạng sữa tắm',
                'htu' => 'Hướng dẫn sử dụng sản phẩm tắm và dưỡng thể',
                'ingredient' => 'Thành phần sản phẩm tắm và dưỡng thể',
                'main_ingredient' => 'Thành phần chính sản phẩm tắm và dưỡng thể',
                'skin' => 'Mọi loại da',
                'stock' => 20,
                'categories_id' => 3, // Tắm và Dưỡng thể
                'total_rating' => 4.8,
                'total_purchase_quantity' => 150,
                'note' => 'Ghi chú sản phẩm tắm và dưỡng thể',
                'promotion_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);

    }
}