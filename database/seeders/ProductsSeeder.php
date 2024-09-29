<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Sản phẩm chăm sóc da',
                'price' => 100.00,
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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sản phẩm chăm sóc tóc',
                'price' => 150.00,
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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sản phẩm tắm và dưỡng thể',
                'price' => 200.00,
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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sản phẩm chăm sóc da new',
                'price' => 100.00,
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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sản phẩm chăm sóc tóc new',
                'price' => 150.00,
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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sản phẩm tắm và dưỡng thể new',
                'price' => 200.00,
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
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}