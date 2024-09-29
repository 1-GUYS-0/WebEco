<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Chăm sóc da'],
            ['name' => 'Chăm sóc tóc'],
            ['name' => 'Tắm và Dưỡng thể'],
            ['name' => 'Dưỡng môi'],
        ];

        DB::table('categories')->insert($categories);
    }
}