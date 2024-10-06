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
                'code' => 'SP-12345',
                'discount_amount' => 50.00,
                'expiry_date' => now()->addDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'VC-12345',
                'discount_amount' => 100.00,
                'expiry_date' => now()->addDays(60),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}