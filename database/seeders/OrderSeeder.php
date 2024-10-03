<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo địa chỉ
        $addressId = DB::table('addresses')->insertGetId([
            'customer_id' => 1,
            'phone' => '0123456789',
            'address' => '123 Đường ABC',
            'province' => 'Hà Nội',
            'district' => 'Quận Hoàn Kiếm',
            'ward' => 'Phường Hàng Bạc',
            'is_default' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // Tạo đơn hàng
        $orderId = DB::table('orders')->insertGetId([ // Tạo đơn hàng và lấy ID của đơn hàng vừa tạo
            'customer_id' => 1,
            'address_id' => $addressId, // Giả sử địa chỉ có ID là 1
            'subtotal' => 200.00,
            'discount' => 0.00,
            'shipping' => 20.00,
            'total' => 220.00,
            'status' => 'pending',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Tạo các sản phẩm trong đơn hàng
        DB::table('order_items')->insert([
            [
                'order_id' => $orderId,
                'product_id' => 1,
                'quantity' => 1,
                'price' => 100.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'order_id' => $orderId,
                'product_id' => 2,
                'quantity' => 1,
                'price' => 100.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Tạo thông tin thanh toán
        DB::table('payments')->insert([
            'order_id' => $orderId,
            'payment_method' => 'cash',
            'amount' => 220.00,
            'payment_date' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);
    }
}
