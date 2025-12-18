@extends('freelance.layouts.app')

@section('title', 'Đăng ký Freelance')

@section('content')
<div class="login-container">
    <div class="login-header">
        <h1 class="logo">Vietlance</h1>
    </div>
    
    <div class="login-card">
        <h2 class="login-title">Sign up to find work you love</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

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

        <div class="divider">
            <span>or</span>
        </div>

        <!-- Form đăng ký -->
        <form method="POST" action="{{ route('freelance.register') }}" class="login-form">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <div class="input-wrapper">
                    <i class="bi bi-person input-icon"></i>
                    <input 
                        type="text" 
                        class="form-input @error('name') is-invalid @enderror" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="Full Name"
                        required 
                        autofocus
                    >
                </div>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-wrapper">
                    <i class="bi bi-envelope input-icon"></i>
                    <input 
                        type="email" 
                        class="form-input @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="Email"
                        required
                    >
                </div>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <i class="bi bi-lock input-icon"></i>
                    <input 
                        type="password" 
                        class="form-input @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        placeholder="Password (min 8 characters)"
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

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div class="input-wrapper">
                    <i class="bi bi-lock input-icon"></i>
                    <input 
                        type="password" 
                        class="form-input" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="Confirm Password"
                        required
                    >
                </div>
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="terms" required>
                    <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
                </label>
            </div>

            <button type="submit" class="btn-continue">
                Create my account
            </button>
        </form>

        <div class="signup-link">
            Already have an account? 
            <a href="{{ route('freelance.login') }}">Log In</a>
        </div>
    </div>

    <div class="login-footer">
        <p>© 2025 Vietlance. Privacy Policy • Your Privacy Choices</p>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/freelance-auth.css') }}">
<style>
    .checkbox-label {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 14px;
        color: #222;
        cursor: pointer;
    }

    .checkbox-label input[type="checkbox"] {
        margin-top: 2px;
    }

    .checkbox-label a {
        color: #14a800;
        text-decoration: none;
    }

    .checkbox-label a:hover {
        text-decoration: underline;
    }
</style>
@endpush

@push('scripts')
<script>
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
</script>
@endpush
@endsection

