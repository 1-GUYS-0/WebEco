<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    // Tên bảng tương ứng trong cơ sở dữ liệu
    protected $table = 'promotions';

    // Các thuộc tính có thể được gán giá trị hàng loạt
    protected $fillable = [
        'name',
        'percent_promotion',
        'promotion_start',
        'promotion_end',
    ];

    // Các thuộc tính sẽ được chuyển đổi thành kiểu dữ liệu tương ứng
    protected $casts = [
        'promotion_start' => 'datetime',
        'promotion_end' => 'datetime',
    ];
}