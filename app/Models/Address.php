<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'address', 'province', 'district', 'ward', 'is_default', 'phone'];

    public function customer() // 1 địa chỉ thuộc về 1 khách hàng
    {
        return $this->belongsTo(Customer::class);
    }
}