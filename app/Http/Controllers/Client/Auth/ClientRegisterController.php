<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ClientRegisterController extends Controller
{
    /**
     * Show the client registration form.
     */
    public function showRegistrationForm()
    {
        return view('client.auth.register');
    }

    /**
     * Handle client registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:client,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'company_name' => ['nullable', 'string', 'max:255'],
            'terms' => ['required', 'accepted'],
        ]);

        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_name' => $request->company_name,
            'is_active' => true,
        ]);

        Auth::guard('client')->login($client);

        return redirect()->route('client.dashboard')
            ->with('success', 'Đăng ký thành công! Chào mừng đến với Vietlance!');
    }
}

