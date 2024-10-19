<?php
namespace App\Http\Controllers\Customer;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('customer_id', Auth::guard('customer')->id())->orderBy('created_at', 'desc')->get();
        return response()->json($notifications);
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('customer_id', Auth::guard('customer')->id())->where('id', $id)->first();
        if ($notification) {
            $notification->is_read = true;
            $notification->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}