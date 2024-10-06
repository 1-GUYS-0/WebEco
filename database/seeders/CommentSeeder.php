<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Dữ liệu thủ công cho bảng comments
        $comments = [
            [
                'product_id' => 1,
                'customer_id' => 1,
                'rating' => 5,
                'images' => json_encode(['storage/comment_images/comment112.jpg', 'storage/comment_images/comment111.jpg']),
                'content' => 'This is a great product!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'customer_id' => 1,
                'rating' => 4,
                'content' => 'Very good quality.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'customer_id' => 2,
                'rating' => 3,
                'content' => 'Average product.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'customer_id' => 2,
                'rating' => 3,
                'images' => json_encode(['storage/comment_images/comment221.jpg']),
                'content' => 'Average product.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Chèn dữ liệu vào bảng comments
        foreach ($comments as $comment) {
            Comment::create($comment);
        }
    }
}
