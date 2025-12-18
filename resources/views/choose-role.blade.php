<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Choose Your Role - Vietlance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('css/choose-role.css') }}">
</head>
<body>
    @include('layouts.partials.header')
    
    <div class="choose-role-wrapper">
        <div class="choose-role-container">
            <div class="choose-role-content">
                <div class="role-selection-card">
                    <h2 class="selection-title">Choose how you want to continue</h2>
                <p class="selection-subtitle">Select your role to get started</p>

                <div class="role-options">
                    <a href="{{ route('talent.login') }}" class="role-card">
                        <div class="role-icon">
                            <i class="bi bi-person-workspace"></i>
                        </div>
                        <h3 class="role-title">I'm a Talent</h3>
                        <p class="role-description">Find work opportunities and grow your freelance career</p>
                        <div class="role-features">
                            <div class="feature-item">
                                <i class="bi bi-check-circle"></i>
                                <span>Browse projects</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-check-circle"></i>
                                <span>Submit proposals</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-check-circle"></i>
                                <span>Get paid securely</span>
                            </div>
                        </div>
                        <div class="role-action">
                            <span class="action-text">Continue as Talent</span>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </a>

                    <a href="{{ route('client.login') }}" class="role-card">
                        <div class="role-icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <h3 class="role-title">I'm a Client</h3>
                        <p class="role-description">Hire talented freelancers for your projects</p>
                        <div class="role-features">
                            <div class="feature-item">
                                <i class="bi bi-check-circle"></i>
                                <span>Post jobs for free</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-check-circle"></i>
                                <span>Review proposals</span>
                            </div>
                            <div class="feature-item">
                                <i class="bi bi-check-circle"></i>
                                <span>Hire top talent</span>
                            </div>
                        </div>
                        <div class="role-action">
                            <span class="action-text">Continue as Client</span>
                            <i class="bi bi-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <div class="back-link">
                    <a href="{{ route('home') }}">
                        <i class="bi bi-arrow-left"></i>
                        Back to homepage
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

