<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id'];

    public function customer() // 1 cart thuộc về 1 khách hàng
    {
        return $this->belongsTo(Customer::class);
    }

    public function cartItems() // 1 cart có nhiều cart item
    {
        return $this->hasMany(CartItem::class);
    }
}