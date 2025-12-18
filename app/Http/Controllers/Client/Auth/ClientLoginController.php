<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\MagicLink;
use App\Mail\MagicLinkMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class ClientLoginController extends Controller
{
    /**
     * Show the client login form.
     */
    public function showLoginForm()
    {
        return view('client.auth.login');
    }

    /**
     * Handle client login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Check if client exists and is active
        $client = Client::where('email', $email)->first();
        
        if ($client && !$client->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Tài khoản của bạn đã bị vô hiệu hóa.'],
            ]);
        }

        // Thử đăng nhập
        if (Auth::guard('client')->attempt(['email' => $email, 'password' => $password], $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('client.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => ['Thông tin đăng nhập không chính xác.'],
        ]);
    }

    /**
     * Gửi magic link đăng nhập nhanh.
     */
    public function sendMagicLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        
        // Kiểm tra email có tồn tại trong hệ thống không
        $client = Client::where('email', $email)->first();
        
        if (!$client) {
            return back()->withErrors(['email' => 'Email này chưa được đăng ký trong hệ thống.'])->withInput();
        }

        // Tạo magic link
        $token = Str::random(64);
        $magicLink = MagicLink::create([
            'email' => $email,
            'token' => $token,
            'user_type' => 'client',
            'expires_at' => now()->addMinutes(15),
        ]);

        // Gửi email
        try {
            Mail::to($email)->send(new MagicLinkMail($magicLink, 'client'));
            
            return back()->with('success', 'Chúng tôi đã gửi link đăng nhập đến email của bạn. Vui lòng kiểm tra hộp thư.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Không thể gửi email. Vui lòng thử lại sau.'])->withInput();
        }
    }

    /**
     * Xử lý magic link đăng nhập.
     */
    public function loginWithMagicLink($token)
    {
        $magicLink = MagicLink::where('token', $token)
            ->where('user_type', 'client')
            ->first();

        if (!$magicLink || !$magicLink->isValid()) {
            return redirect()->route('client.login')
                ->withErrors(['error' => 'Link đăng nhập không hợp lệ hoặc đã hết hạn.']);
        }

        $client = Client::where('email', $magicLink->email)->first();

        if (!$client) {
            return redirect()->route('client.login')
                ->withErrors(['error' => 'Tài khoản không tồn tại.']);
        }

        // Đánh dấu magic link đã sử dụng
        $magicLink->markAsUsed();

        // Đăng nhập
        Auth::guard('client')->login($client, true);

        return redirect()->route('client.dashboard')
            ->with('success', 'Đăng nhập thành công!');
    }

    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Tìm client theo email
            $client = Client::where('email', $googleUser->getEmail())->first();

            if ($client) {
                // Cập nhật avatar nếu có
                if (!$client->avatar) {
                    $client->update(['avatar' => $googleUser->getAvatar()]);
                }
            } else {
                // Tạo tài khoản mới từ Google
                $client = Client::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make(uniqid()),
                    'is_active' => true,
                ]);
            }

            // Đăng nhập
            Auth::guard('client')->login($client, true);

            return redirect()->route('client.dashboard');

        } catch (\Exception $e) {
            return redirect()->route('client.login')
                ->withErrors(['error' => 'Đăng nhập bằng Google thất bại. Vui lòng thử lại.']);
        }
    }

    /**
     * Handle client logout request.
     */
    public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('client.login');
    }
}

