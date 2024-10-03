<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
            $table->decimal('subtotal', 10, 2); // tổng giá trị sản phẩm
            $table->decimal('discount', 10, 2)->default(0); // giảm giá
            $table->decimal('shipping', 10, 2); // phí vận chuyển
            $table->decimal('total', 10, 2); // tổng tiền cần thanh toán
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}