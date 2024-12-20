<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomerResetPasswordNotification;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $fillable = [ 'name', 'email', 'number_phone', 'password', 'status', 'verification_token','avatar_path'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime'];

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
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomerResetPasswordNotification($token));
    }
    public function notifications() // 1 customer có thể có nhiều thông báo
    {
        return $this->hasMany(Notification::class);
    }
}