<?php

namespace App\Models;

use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'name',
        'brand',
        'weight',
        'price',
        'description',
        'smell',
        'texture',
        'htu',
        'ingredient',
        'main_ingredient',
        'skin',
        'stock',
        'categories_id',
        'note',
        'promotion_id',
    ];

    // Xác định quan hệ với bảng product_images
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    //Xác định quan hệ với bảng categories
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class); // Một sản phẩm có thể có nhiều comment
    }
    public function promotion()
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }
}
