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
            // $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('shipping_method');
            $table->text('message')->nullable();
            $table->integer('subtotal'); // tổng giá trị sản phẩm
            $table->decimal('discount', 10, 2)->default(0); // giảm giá
            $table->integer('shipping'); // phí vận chuyển
            $table->integer('total_price'); // tổng tiền cần thanh toán
            $table->integer('order_quantity'); // tổng số lượng sản phẩm
            $table->enum('status', ['pending', 'shipping', 'completed', 'rated', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}