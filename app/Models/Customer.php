<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

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
    public function sessions() // 1 customer có thể có nhiều session
    {
        return $this->hasOne(Session::class, 'customer_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class); // 1 customer có thể có nhiều comment
    }
}