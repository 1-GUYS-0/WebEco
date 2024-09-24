<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'image_path',
        'image_type',
        'product_id',
    ];
    // Xác định quan hệ với bảng products
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
