<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('images_path'); // Mảng chứa đường dẫn 1 ảnh của banner
            $table->date('start_date'); // Ngày bắt đầu hiển thị banner
            $table->date('end_date'); // Ngày kết thúc hiển thị banner
            $table->string('link_to')->nullable(); // Đường dẫn khi click vào banner
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banners');
    }
}