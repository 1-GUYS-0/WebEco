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
            $table->foreignId('categories_id')->constrained('categories', 'id')->onDelete('cascade'); // Foreign key constraint
            $table->decimal('total_rating', 3, 2)->nullable(); // TotalRating
            $table->integer('total_purchase_quantity')->nullable(); // TotalPurchaseQuantity
            $table->string('note'); // Note
            $table->timestamps(); // CreatedAt and EditedAt (Laravel's default timestamps)
        });
    }
    



    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
