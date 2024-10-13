<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VNPayPayment extends Model
{
    use HasFactory;

    protected $table = 'vnpaypayments';

    protected $fillable = [
        'payment_id',
        'vnp_bank_code',
        'vnp_amount',
        'vnp_paydate',
        'vnp_txn_ref',
        'vnp_transaction_no',
        'vnp_create_by_id'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}