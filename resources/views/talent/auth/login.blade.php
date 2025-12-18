@extends('client.layouts.app')

@section('title', 'Đăng nhập Talent')

@section('content')
<div class="login-container">
    
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
        <form method="POST" action="{{ route('talent.login') }}" class="login-form" id="loginForm">
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
            <a href="{{ route('talent.google.redirect') }}" class="btn-social btn-google">
                <svg width="18" height="18" viewBox="0 0 18 18">
                    <path fill="#4285F4" d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z"/>
                    <path fill="#34A853" d="M9 18c2.43 0 4.467-.806 5.956-2.184l-2.908-2.258c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332C2.438 15.983 5.482 18 9 18z"/>
                    <path fill="#FBBC05" d="M3.964 10.707c-.18-.54-.282-1.117-.282-1.707s.102-1.167.282-1.707V4.961H.957C.348 6.175 0 7.55 0 9s.348 2.825.957 4.039l3.007-2.332z"/>
                    <path fill="#EA4335" d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0 5.482 0 2.438 2.017.957 4.961L3.964 7.293C4.672 5.163 6.656 3.58 9 3.58z"/>
                </svg>
                Continue with Google
            </a>
            <a href="{{ route('talent.github.redirect') }}" class="btn-social btn-github">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 0C4.03 0 0 4.03 0 9c0 3.98 2.58 7.35 6.16 8.54.45.08.62-.2.62-.44 0-.22-.01-.79-.01-1.54-2.5.54-3.03-1.21-3.03-1.21-.41-1.04-1-1.32-1-1.32-.82-.56.06-.55.06-.55.91.06 1.39.93 1.39.93.8 1.38 2.11.98 2.62.75.08-.58.31-.98.57-1.21-2-.23-4.1-1-4.1-4.45 0-.98.35-1.78.93-2.41-.09-.23-.4-1.14.09-2.38 0 0 .76-.24 2.49.92.72-.2 1.5-.3 2.27-.3.77 0 1.55.1 2.27.3 1.73-1.16 2.49-.92 2.49-.92.49 1.24.18 2.15.09 2.38.58.63.93 1.43.93 2.41 0 3.46-2.1 4.22-4.1 4.44.32.28.61.83.61 1.67 0 1.21-.01 2.18-.01 2.48 0 .24.17.53.62.44A9.01 9.01 0 0018 9c0-4.97-4.03-9-9-9z"/>
                </svg>
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
                <form method="POST" action="{{ route('talent.magic-link.send') }}">
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
            <a href="{{ route('talent.register') }}">Sign Up</a>
        </div>
    </div>

</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/freelance-auth.css') }}">
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

