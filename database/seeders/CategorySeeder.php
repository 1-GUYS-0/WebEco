<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Chăm sóc da'],
            ['name' => 'Chăm sóc tóc'],
            ['name' => 'Tắm và Dưỡng thể'],
            ['name' => 'Dưỡng môi'],
        ]);
    }
}
