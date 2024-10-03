<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class CustomerController extends Controller
{
    public function profile($id)
    {
        $orders = Order::with(['orderItems.product', 'payment'])->where('customer_id', $id)->get();
        return view('customer.pages.profile', compact('orders'));
        // return response()->json($orders);
    }
}
