<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name'); // Tên voucher
            $table->decimal('discount_amount', 8, 2); // Số tiền giảm giá
            $table->integer('quantity')->default(0); // Số lượng voucher
            $table->string('image_path')->nullable(); // Mô tả voucher
            $table->time('start_time')->default('00:00:00'); // Thời gian bắt đầu áp dụng
            $table->time('end_time')->default('23:59:59'); // Thời gian kết thúc áp dụng
            $table->date('expiry_date'); // Ngày hết hạn của voucher
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}