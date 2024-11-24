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
        DB::table('addresses')->insert([
            [
                'customer_id' => 1,
                'phone' => '0123456789',
                'address' => '123 Đường ABC',
                'province' => 'Hà Nội',
                'district' => 'Quận Hoàn Kiếm',
                'ward' => 'Phường Hàng Bạc',
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'customer_id' => 1,
                'phone' => '0987654321',
                'address' => '456 Đường XYZ',
                'province' => 'Hà Nội',
                'district' => 'Quận Hai Bà Trưng',
                'ward' => 'Phường Lê Đại Hành',
                'is_default' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'customer_id' => 1,
                'phone' => '0123456789',
                'address' => '789 Đường KLM',
                'province' => 'Hà Nội',
                'district' => 'Quận Đống Đa',
                'ward' => 'Phường Láng Hạ',
                'is_default' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
        $orderCsvFile = fopen(base_path("database/data/order.csv"), "r");
        $firstOrderLine = true;

        while (($orderData = fgetcsv($orderCsvFile, 2000, ",")) !== FALSE) {
            if (!$firstOrderLine) {
                DB::table('orders')->insert([
                    'customer_id' => $orderData[0],
                    'name' => $orderData[1],
                    'address' => $orderData[2],
                    'phone' => $orderData[3],
                    'shipping_method' => $orderData[4],
                    'message' => $orderData[5],
                    'subtotal' => $orderData[6],
                    'discount' => $orderData[7],
                    'shipping' => $orderData[8],
                    'total_price' => $orderData[9],
                    'order_quantity' => $orderData[10],
                    'status' => $orderData[11],
                    'created_at' => Carbon::parse($orderData[12]),
                    'updated_at' => Carbon::parse($orderData[13]),
                ]);
            }
            $firstOrderLine = false;
        }

        fclose($orderCsvFile);

        $orderItemCsvFile = fopen(base_path("database/data/order_item.csv"), "r");
        $firstOrderItemLine = true;

        while (($orderItemData = fgetcsv($orderItemCsvFile, 2000, ",")) !== FALSE) {
            if (!$firstOrderItemLine) {
                DB::table('order_items')->insert([
                    'order_id' => $orderItemData[0],
                    'product_id' => $orderItemData[1],
                    'quantity' => $orderItemData[2],
                    'price' => $orderItemData[3],
                    'created_at' => Carbon::parse($orderItemData[4]),
                    'updated_at' => Carbon::parse($orderItemData[5]),
                ]);
            }
            $firstOrderItemLine = false;
        }

        fclose($orderItemCsvFile);

        $paymentCsvFile = fopen(base_path("database/data/payment.csv"), "r");
        $firstPaymentLine = true;
        $orderId = 1; // Giả sử tất cả các thanh toán thuộc về đơn hàng có ID là 1

        while (($paymentData = fgetcsv($paymentCsvFile, 2000, ",")) !== FALSE) {
            if (!$firstPaymentLine) {
                DB::table('payments')->insert([
                    'order_id' => $paymentData[0],
                    'payment_method' => $paymentData[1],
                    'amount' => $paymentData[2],
                    'status' => $paymentData[3],
                    'payment_date' => Carbon::parse($paymentData[4]),
                    'created_at' => Carbon::parse($paymentData[5]),
                    'updated_at' => Carbon::parse($paymentData[6]),
                ]);
                $orderId++; // Tăng order_id cho mỗi lần lặp
            }
            $firstPaymentLine = false;
        }

        fclose($paymentCsvFile);
    }
}
