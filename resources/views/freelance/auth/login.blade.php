@extends('freelance.layouts.app')

@section('title', 'Đăng nhập Freelance')

@section('content')
<div class="login-container">
    <div class="login-header">
        <h1 class="logo">Vietlance</h1>
    </div>
    
    <div class="login-card">
        <h2 class="login-title">Log in to Vietlance</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form đăng nhập email -->
        <form method="POST" action="{{ route('freelance.login') }}" class="login-form" id="loginForm">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Username or Email</label>
                <div class="input-wrapper">
                    <i class="bi bi-person input-icon"></i>
                    <input 
                        type="text" 
                        class="form-input @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="Username or Email"
                        required 
                        autofocus
                    >
                </div>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" id="passwordGroup" style="display: none;">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <i class="bi bi-lock input-icon"></i>
                    <input 
                        type="password" 
                        class="form-input @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        placeholder="Password"
                        required
                    >
                    <button 
                        type="button" 
                        class="toggle-password"
                        id="togglePassword"
                    >
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-continue" id="continueBtn">
                Continue
            </button>
        </form>

        <div class="divider">
            <span>or</span>
        </div>

        <!-- Social Login Buttons -->
        <div class="social-buttons">
            <a href="{{ route('freelance.google.redirect') }}" class="btn-social btn-google">
                <svg width="18" height="18" viewBox="0 0 18 18">
                    <path fill="#4285F4" d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z"/>
                    <path fill="#34A853" d="M9 18c2.43 0 4.467-.806 5.956-2.184l-2.908-2.258c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332C2.438 15.983 5.482 18 9 18z"/>
                    <path fill="#FBBC05" d="M3.964 10.707c-.18-.54-.282-1.117-.282-1.707s.102-1.167.282-1.707V4.961H.957C.348 6.175 0 7.55 0 9s.348 2.825.957 4.039l3.007-2.332z"/>
                    <path fill="#EA4335" d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0 5.482 0 2.438 2.017.957 4.961L3.964 7.293C4.672 5.163 6.656 3.58 9 3.58z"/>
                </svg>
                Continue with Google
            </a>

            <a href="{{ route('freelance.github.redirect') }}" class="btn-social btn-github">
                <i class="bi bi-github"></i>
                Continue with GitHub
            </a>
        </div>

        <!-- Magic Link -->
        <div class="magic-link-section">
            <button type="button" class="btn-magic-link" id="toggleMagicLink">
                <i class="bi bi-envelope"></i>
                Login with email link
            </button>
            <div class="magic-link-form" id="magicLinkForm" style="display: none;">
                <form method="POST" action="{{ route('freelance.magic-link.send') }}">
                    @csrf
                    <div class="form-group">
                        <input 
                            type="email" 
                            class="form-input" 
                            name="email" 
                            placeholder="Enter your email"
                            required
                        >
                    </div>
                    <button type="submit" class="btn-continue btn-sm">
                        Send login link
                    </button>
                </form>
            </div>
        </div>

        <div class="signup-link">
            Don't have a Vietlance account? 
            <a href="{{ route('freelance.register') }}">Sign Up</a>
        </div>
    </div>

    <div class="login-footer">
        <p>© 2025 Vietlance. Privacy Policy • Your Privacy Choices</p>
    </div>
</div>

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        background-color: #f5f5f5;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .login-container {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-header {
        width: 100%;
        max-width: 400px;
        margin-bottom: 20px;
    }

    .logo {
        font-size: 24px;
        font-weight: 600;
        color: #14a800;
        text-align: left;
    }

    .login-card {
        background: white;
        border-radius: 8px;
        padding: 40px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .login-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 30px;
        color: #222;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 8px;
        color: #222;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 12px;
        color: #999;
        font-size: 18px;
    }

    .form-input {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
        transition: border-color 0.2s;
    }

    .form-input:focus {
        outline: none;
        border-color: #14a800;
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        padding: 0;
    }

    .error-message {
        color: #d93025;
        font-size: 12px;
        margin-top: 4px;
    }

    .btn-continue {
        width: 100%;
        padding: 12px;
        background-color: #14a800;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
        margin-top: 10px;
    }

    .btn-continue:hover {
        background-color: #0f8500;
    }

    .btn-continue.btn-sm {
        padding: 8px;
        font-size: 14px;
    }

    .divider {
        text-align: center;
        margin: 24px 0;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #ddd;
    }

    .divider span {
        background: white;
        padding: 0 16px;
        color: #999;
        position: relative;
    }

    .social-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-social {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: white;
        color: #222;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        transition: background-color 0.2s;
    }

    .btn-social:hover {
        background-color: #f9f9f9;
    }

    .btn-google {
        color: #222;
    }

    .btn-github {
        color: #222;
    }

    .magic-link-section {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .btn-magic-link {
        width: 100%;
        padding: 12px;
        background: none;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #222;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-magic-link:hover {
        background-color: #f9f9f9;
    }

    .magic-link-form {
        margin-top: 16px;
    }

    .signup-link {
        text-align: center;
        margin-top: 24px;
        font-size: 14px;
        color: #222;
    }

    .signup-link a {
        color: #14a800;
        text-decoration: none;
        font-weight: 500;
    }

    .signup-link a:hover {
        text-decoration: underline;
    }

    .login-footer {
        width: 100%;
        max-width: 400px;
        text-align: center;
        padding: 20px;
        color: #999;
        font-size: 12px;
    }

    .alert {
        padding: 12px;
        border-radius: 4px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-danger {
        background-color: #fee;
        color: #d93025;
        border: 1px solid #fcc;
    }

    .alert-success {
        background-color: #e6f4ea;
        color: #137333;
        border: 1px solid #b7e1cd;
    }
</style>
@endpush

@push('scripts')
<script>
    let emailEntered = false;

    document.getElementById('email').addEventListener('blur', function() {
        const email = this.value.trim();
        if (email && !emailEntered) {
            emailEntered = true;
            document.getElementById('passwordGroup').style.display = 'block';
            document.getElementById('continueBtn').textContent = 'Log In';
        }
    });

    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('bi-eye');
            eyeIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('bi-eye-slash');
            eyeIcon.classList.add('bi-eye');
        }
    });

    document.getElementById('toggleMagicLink').addEventListener('click', function() {
        const form = document.getElementById('magicLinkForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
</script>
@endpush
@endsection
