<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'payment_method', 'amount', 'transaction_id'];

    public function order() // 1 payment thuộc về 1 order
    {
        return $this->belongsTo(Order::class);
    }
}