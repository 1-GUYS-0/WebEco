<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function index()
    {
        // $payments = Payment::with('order')->get();
        // return view('admin.orders-manager', compact('payments'));
        // //return json_encode($payments);
        // //dump($payments);
    }
}
