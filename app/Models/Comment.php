<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['product_id', 'customer_id', 'rating', 'content'];

    public function product()
    {
        return $this->belongsTo(Product::class); // Một comment thuộc về một sản phẩm
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class); // Một comment thuộc về một khách hàng
    }
}
