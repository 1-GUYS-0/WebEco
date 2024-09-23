<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id(); // ID
            $table->string('image_path'); // Đường dẫn tới hình ảnh
            $table->string('image_type')->nullable(); // Loại hình ảnh (ví dụ: thumbnail, gallery, etc.)
            $table->timestamps(); // CreatedAt và UpdatedAt

            // Thiết lập khóa ngoại
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Khóa ngoại liên kết với bảng products
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
