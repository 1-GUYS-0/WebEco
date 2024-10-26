<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function build()
    {
        return $this->view('customer.auth.email.verify')
                    ->subject('Xác nhận địa chỉ Email đăng ký tài khoản tại Green Nature Cosmetics Webssite')
                    ->with([
                        'customer' => $this->customer,
                        'verificationUrl' => route('customer.verify', $this->customer->verification_token),
                    ]);
    }
}
