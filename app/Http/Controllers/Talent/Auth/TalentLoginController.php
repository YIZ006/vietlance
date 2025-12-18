<?php

namespace App\Http\Controllers\Talent\Auth;

use App\Http\Controllers\Controller;
use App\Models\Talent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class TalentLoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('talent.auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        // Check if talent exists and is active
        $talent = Talent::where('email', $credentials['email'])->first();
        
        if ($talent && !$talent->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Tài khoản của bạn đã bị vô hiệu hóa.'],
            ]);
        }

        if (Auth::guard('talent')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('talent.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => ['Thông tin đăng nhập không chính xác.'],
        ]);
    }

    /**
     * Redirect to GitHub OAuth.
     */
    public function redirectToGithub()
    {
        return \Laravel\Socialite\Facades\Socialite::driver('github')
            ->redirect();
    }

    /**
     * Handle GitHub OAuth callback.
     */
    public function handleGithubCallback()
    {
        try {
            $githubUser = \Laravel\Socialite\Facades\Socialite::driver('github')->user();

            $talent = Talent::where('github_id', $githubUser->id)->first();

            if (!$talent) {
                // Check if email already exists
                $existingTalent = Talent::where('email', $githubUser->email)->first();
                
                if ($existingTalent) {
                    // Update existing talent with GitHub info
                    $existingTalent->update([
                        'github_id' => $githubUser->id,
                        'github_token' => $githubUser->token,
                        'github_refresh_token' => $githubUser->refreshToken,
                    ]);
                    $talent = $existingTalent;
                } else {
                    // Create new talent
                    $talent = Talent::create([
                        'name' => $githubUser->name ?? $githubUser->nickname,
                        'email' => $githubUser->email,
                        'github_id' => $githubUser->id,
                        'github_token' => $githubUser->token,
                        'github_refresh_token' => $githubUser->refreshToken,
                        'password' => Hash::make(Str::random(16)),
                        'avatar' => $githubUser->avatar,
                        'is_active' => true,
                    ]);
                }
            } else {
                // Update token
                $talent->update([
                    'github_token' => $githubUser->token,
                    'github_refresh_token' => $githubUser->refreshToken,
                ]);
            }

            Auth::guard('talent')->login($talent, true);

            return redirect()->route('talent.dashboard');
        } catch (\Exception $e) {
            return redirect()->route('talent.login')
                ->with('error', 'Đăng nhập bằng GitHub thất bại. Vui lòng thử lại.');
        }
    }

    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle()
    {
        return \Laravel\Socialite\Facades\Socialite::driver('google')
            ->redirect();
    }

    /**
     * Handle Google OAuth callback.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->user();

            $talent = Talent::where('email', $googleUser->email)->first();

            if (!$talent) {
                $talent = Talent::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make(Str::random(16)),
                    'avatar' => $googleUser->avatar,
                    'is_active' => true,
                ]);
            }

            Auth::guard('talent')->login($talent, true);

            return redirect()->route('talent.dashboard');
        } catch (\Exception $e) {
            return redirect()->route('talent.login')
                ->with('error', 'Đăng nhập bằng Google thất bại. Vui lòng thử lại.');
        }
    }

    /**
     * Send magic link email.
     */
    public function sendMagicLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $talent = Talent::where('email', $request->email)->first();

        if (!$talent) {
            return back()->with('error', 'Email không tồn tại trong hệ thống.');
        }

        $token = Str::random(64);
        
        \App\Models\MagicLink::create([
            'email' => $request->email,
            'token' => Hash::make($token),
            'user_type' => 'talent',
            'expires_at' => now()->addMinutes(15),
        ]);

        \Illuminate\Support\Facades\Mail::to($request->email)->send(
            new \App\Mail\MagicLinkMail(
                (object)['token' => $token],
                'talent'
            )
        );

        return back()->with('success', 'Chúng tôi đã gửi link đăng nhập đến email của bạn. Vui lòng kiểm tra hộp thư.');
    }

    /**
     * Login with magic link.
     */
    public function loginWithMagicLink($token)
    {
        $magicLinks = \App\Models\MagicLink::where('user_type', 'talent')
            ->where('expires_at', '>', now())
            ->get();

        foreach ($magicLinks as $magicLink) {
            if (Hash::check($token, $magicLink->token)) {
                $talent = Talent::where('email', $magicLink->email)->first();
                
                if ($talent) {
                    Auth::guard('talent')->login($talent, true);
                    $magicLink->delete();
                    return redirect()->route('talent.dashboard')
                        ->with('success', 'Đăng nhập thành công!');
                }
            }
        }

        return redirect()->route('talent.login')
            ->with('error', 'Link đăng nhập không hợp lệ hoặc đã hết hạn.');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::guard('talent')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('talent.login');
    }
}

