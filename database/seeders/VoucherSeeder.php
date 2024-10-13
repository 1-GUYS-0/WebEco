<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vouchers')->insert([
            [
                'code' => 'SP-10-00',
                'name' => 'Sale All Time',
                'discount_amount' => 50.00,
                'expiry_date' => now()->addDays(30),
                'quantity'=>1,
                'image_path' => 'system/sp-10.webp',
                'start_time' => '00:00:00', // Thời gian bắt đầu áp dụng
                'end_time' => '23:59:59', // Thời gian kết thúc áp dụng
            ],
            [
                'code' => 'SP-25-00',
                'name' => 'Sale All Time',
                'discount_amount' => 25.00,
                'expiry_date' => now()->addDays(30),
                'quantity'=>50,
                'image_path' => 'system/sp-25.webp',
                'start_time' => '00:00:00', // Thời gian bắt đầu áp dụng
                'end_time' => '23:59:59', // Thời gian kết thúc áp dụng
            ],
            [
                'code' => 'SP-50-30',
                'name' => '9-12 Gold hours Sale',
                'discount_amount' => 50.00,
                'expiry_date' => now()->addDays(30),
                'quantity'=>50,
                'image_path' => 'system/sp-50.webp',
                'start_time' => '09:00:00', // Thời gian bắt đầu áp dụng
                'end_time' => '12:00:00', // Thời gian kết thúc áp dụng
            ],
            [
                'code' => 'VC-100-00',
                'name' => '9-12 Gold hours Sale',
                'discount_amount' => 100.00,
                'expiry_date' => now()->addDays(30),
                'quantity'=>50,
                'image_path' => 'system/vc-mp.webp',
                'start_time' => '09:00:00', // Thời gian bắt đầu áp dụng
                'end_time' => '12:00:00', // Thời gian kết thúc áp dụng
            ],
            [
                'code' => 'VC-50-00',
                'name' => 'Sale All Time',
                'discount_amount' => 50.00,
                'expiry_date' => now()->addDays(30),
                'quantity'=>25,
                'image_path' => 'system/vc-50.webp',
                'start_time' => '00:00:00', // Thời gian bắt đầu áp dụng
                'end_time' => '23:59:59', // Thời gian kết thúc áp dụng
            ],
            [
                'code' => 'VC-25-00',
                'name' => 'Sale All Time',
                'discount_amount' => 25.00,
                'expiry_date' => now()->addDays(30),
                'quantity'=>1,
                'image_path' => 'system/vc-25.webp',
                'start_time' => '00:00:00', // Thời gian bắt đầu áp dụng
                'end_time' => '23:59:59', // Thời gian kết thúc áp dụng
            ],
        ]);
    }
}