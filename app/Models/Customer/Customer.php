<?php
namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email'];

    public function addresses() // 1 customer có thể có nhiều địa chỉ
    {
        return $this->hasMany(Address::class);
    }

    public function orders() // 1 customer có thể có nhiều order
    {
        return $this->hasMany(Order::class);
    }

    public function cart() // 1 customer có thể có 1 giỏ hàng
    {
        return $this->hasOne(Cart::class);
    }
}