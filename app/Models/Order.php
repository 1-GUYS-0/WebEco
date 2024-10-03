<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'address_id', 'subtotal', 'discount', 'shipping', 'total', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderItems() // 1 order có nhiều order item
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address() // 1 order có 1 địa chỉ
    {
        return $this->belongsTo(Address::class);
    }

    public function payment() // 1 order có 1 payment
    {
        return $this->hasOne(Payment::class);
    }
}