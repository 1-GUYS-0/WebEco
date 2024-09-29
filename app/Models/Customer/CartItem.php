<?php
namespace App\Models\Customer; // Khai báo tên namespace cho model này

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    public function cart() // 1 cart item thuộc về 1 cart
    {
        return $this->belongsTo(Cart::class);
    }

    public function product() // 1 cart item thuộc về 1 product
    {
        return $this->belongsTo(Product::class);
    }
}