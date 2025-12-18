<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccessController extends Controller
{
    /**
     * Redirect to admin login or dashboard based on auth status
     */
    public function access(Request $request)
    {
        // Nếu đã đăng nhập, chuyển đến dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        // Nếu chưa đăng nhập, chuyển đến trang đăng nhập
        return redirect()->route('admin.login');
    }
}

