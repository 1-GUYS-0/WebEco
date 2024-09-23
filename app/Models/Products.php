<?php

namespace App\Models;
use App\Models\ProductImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'name',
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
        'total_rating',
        'total_purchase_quantity',
    ];

    // Xác định quan hệ với bảng product_images
    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id');
    }
}
