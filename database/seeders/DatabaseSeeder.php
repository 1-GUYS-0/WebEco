<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategoriesSeeder::class, 
            ProductsSeeder::class,
            ProductImagesSeeder::class,
            CustomerSeeder::class,
            BannersSeeder::class,
            CommentSeeder::class,
            OrderSeeder::class,
            VoucherSeeder::class,
            AdminsSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
