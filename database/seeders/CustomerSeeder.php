<?php

namespace Database\Seeders;

use App\Models\CartItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Cart;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo dữ liệu mẫu cho bảng customers
        Customer::create([
            'name' => 'Việt Hoàng',
            'email' => 'viethoang@gmail.com',
            'number_phone' => '0123456789',
            'password' => Hash::make('123456'), // Mã hóa mật khẩu
            'avatar_path' => '/storage/avatar_customer/avatar_u1.webp',
        ]);

        // Customer::create([
        //     'name' => 'Guys',
        //     'email' => '20166016@st.hcmuaf.edu.vn',
        //     'number_phone' => '0123456798',
        //     'password' => Hash::make('password123'), // Mã hóa mật khẩu
        //     'avatar_path' => 'storage/avatar_customer/avatar_u2.webp'
        // ]);

        Customer::create([
            'name' => 'Alice',
            'email' => 'alice@gmail.com',
            'number_phone' => '0123456701',
            'password' => Hash::make('password123'), // Mã hóa mật khẩu
            'avatar_path' => '/storage/avatar_customer/avatar_u3.webp'
        ]);

        // Bạn có thể thêm nhiều dữ liệu mẫu khác tại đây
        Cart::create([
            'customer_id' => 1,
        ]); // John Doe có 1 giỏ hàng
        CartItem::create([
            'cart_id' => 1,
            'product_id' => 1,
            'quantity' => 2,
        ]); // John Doe mua 2 sản phẩm có id = 1
    }
}
