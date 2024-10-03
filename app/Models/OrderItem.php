<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    public function order() // 1 order item thuộc về 1 order
    {
        return $this->belongsTo(Order::class);
    }

    public function product() // 1 order item thuộc về 1 product
    {
        return $this->belongsTo(Product::class);
    }
}