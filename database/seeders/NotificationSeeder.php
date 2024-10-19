<?php
namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        // Lấy tất cả người dùng
        $customers = Customer::all();

        // Tạo thông báo mẫu cho mỗi người dùng
        foreach ($customers as $customer) {
            Notification::create([
                'customer_id' => $customer->id,
                'title' => 'Thông báo mẫu',
                'message' => 'Đây là thông báo mẫu cho người dùng ' . $customer->name,
                'is_read' => false,
            ]);
        }
    }
}