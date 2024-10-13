<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVnpaypaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vnpaypayments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->onDelete('cascade'); // Khóa ngoại liên kết với bảng payments
            $table->string('vnp_bank_code'); // Mã ngân hàng
            $table->string('vnp_amount'); // Số tiền thanh toán
            $table->string('vnp_paydate'); // Thời gian ghi nhận thanh toán
            $table->string('vnp_txn_ref'); // Mã tham chiếu của giao dịch
            $table->string('vnp_transaction_no'); // Mã phản hồi của VNPAY
            $table->string('vnp_create_by_id'); // Mã người khởi tạo hoàn tiền
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
        Schema::dropIfExists('vnpaypayments');
    }
}