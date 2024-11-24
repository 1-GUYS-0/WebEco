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
            $table->string('brand')->nullable(); // Brand
            $table->string('name'); // Name
            $table->string('weight')->nullable(); // Weight
            $table->string('type')->nullable(); // Type
            $table->integer('price'); // Price
            $table->text('description')->nullable(); // Description
            $table->string('smell')->nullable(); // Smell
            $table->string('texture')->nullable(); // Texture
            $table->text('htu')->nullable(); // HTU (How To Use)
            $table->text('ingredient')->nullable(); // Ingredient
            $table->string('main_ingredient')->nullable(); // MainIngredient
            $table->string('skin')->nullable(); // Skin
            $table->integer('stock')->default(0); // Stock
            $table->foreignId('categories_id')->nullable()->constrained('categories', 'id')->onDelete('cascade'); // Foreign key constraint
            $table->decimal('total_rating', 3, 2)->nullable(); // TotalRating
            $table->integer('total_purchase_quantity')->nullable(); // TotalPurchaseQuantity
            $table->string('note')->nullable(); // Note
            $table->foreignId('promotion_id')->nullable()->constrained('promotions', 'id')->onDelete('cascade'); // PromotionID
            $table->timestamps(); // CreatedAt and EditedAt (Laravel's default timestamps)
        });
    }
    



    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
