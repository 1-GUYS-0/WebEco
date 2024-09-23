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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // ID
            $table->string('name'); // Name
            $table->decimal('price', 8, 2); // Price
            $table->text('description'); // Description
            $table->string('smell'); // Smell
            $table->string('texture'); // Texture
            $table->text('htu'); // HTU (How To Use)
            $table->text('ingredient'); // Ingredient
            $table->string('main_ingredient'); // MainIngredient
            $table->string('skin'); // Skin
            $table->integer('stock'); // Stock
            $table->unsignedBigInteger('categories_id'); // CategoriesId
            $table->decimal('total_rating', 3, 2); // TotalRating
            $table->integer('total_purchase_quantity'); // TotalPurchaseQuantity
            $table->timestamps(); // CreatedAt and EditedAt (Laravel's default timestamps)

            // Set foreign key
            $table->foreign('categories_id')->references('id')->on('categories')->onDelete('cascade'); // khóa ngoại liên kết với bảng categories
        });
    }
    



    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
