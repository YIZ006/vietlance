<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Xác định đăng nhập bằng email hay admin_login
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'admin_login';

        // Tìm admin trước để kiểm tra trạng thái khóa
        $admin = \App\Models\Admin::where($field, $login)->first();

        if ($admin) {
            // Kiểm tra trạng thái tài khoản
            if ($admin->status === 'locked' || $admin->status === 'inactive') {
                throw ValidationException::withMessages([
                    'login' => ['Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ admin qua email: admin@vietlance.com để được hỗ trợ.'],
                ]);
            }
        }

        // Thử đăng nhập
        if (Auth::guard('admin')->attempt([$field => $login, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard.secure'));
        }

        throw ValidationException::withMessages([
            'login' => ['Thông tin đăng nhập không chính xác.'],
        ]);
    }

    /**
     * Handle admin logout request.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}

