<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->check()) {
            // Nếu không phải admin, chuyển hướng đến trang đăng nhập hoặc trang lỗi
            return redirect()->route('admin.show-login')->with('error', 'Bạn không có quyền truy cập trang này.');
        }

        // Nếu là admin, tiếp tục xử lý request
        return $next($request);
    }
}
