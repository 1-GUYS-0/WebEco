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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên chương trình khuyến mãi
            $table->decimal('percent_promotion', 5, 2); // Phần trăm khuyến mãi
            $table->dateTime('promotion_start'); // Promotion Start Time
            $table->dateTime('promotion_end'); // Promotion End Time
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
