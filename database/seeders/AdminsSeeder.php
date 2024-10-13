<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo dữ liệu mẫu cho bảng admins
        DB::table('admins')->insert(
            [
                [
                    'name' => 'admin',
                    'email' => 'dvq@gmail.com',
                    'password' => Hash::make('123456'),
                    'role' => 'admin',
                ],
                [
                    'name' => 'consultant',
                    'email' => 'nv1@gmail.com',
                    'password' => Hash::make('123456'),
                    'role' => 'consultant',
                ]
            ]
        );
    }
}
