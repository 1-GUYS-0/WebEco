<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role !== 'admin') {
            // Nếu không phải admin hoặc role không phải admin, chuyển hướng đến trang dashboard
            return redirect()->route('dashboards.showDashboardMng')->with('error', 'Bạn không có quyền truy cập trang này.');
        }

        // Nếu là admin và role là admin, tiếp tục xử lý request
        return $next($request);
    }
}
