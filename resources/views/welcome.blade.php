<!DOCTYPE html>
<html lang="vi">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vietlance - Hire Top Freelance Talent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    </head>
<body>
    <!-- Header -->
    <header class="landing-header">
        <div class="container">
            <nav class="navbar">
                <div class="navbar-brand">
                    <a href="{{ route('home') }}" class="logo">Vietlance</a>
                </div>
                <div class="navbar-nav">
                    <a href="#" class="nav-link">Hire freelancers</a>
                    <a href="#" class="nav-link">Find work</a>
                    <a href="#" class="nav-link">Why Vietlance</a>
                    <a href="#" class="nav-link">What's new</a>
                    <a href="#" class="nav-link">Pricing</a>
                    <a href="#" class="nav-link">For enterprise</a>
                </div>
                <div class="navbar-actions">
                    <a href="{{ route('choose-role') }}" class="btn-login">Log in</a>
                    <a href="{{ route('choose-role') }}" class="btn-signup">Sign up</a>
                </div>
                </nav>
        </div>
        </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Find your next hire for a short task or long-term growth</h1>
                <a href="{{ route('choose-role') }}" class="btn-hero">Explore Freelancers</a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="container">
            <div class="categories-grid">
                <div class="category-card">
                    <div class="category-icon">
                        <i class="bi bi-code-square"></i>
                    </div>
                    <div class="category-title">Development & IT</div>
                </div>
                <div class="category-card">
                    <div class="category-icon">
                        <i class="bi bi-palette"></i>
                    </div>
                    <div class="category-title">Design & Creative</div>
                </div>
                <div class="category-card">
                    <div class="category-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="category-title">Sales & Marketing</div>
                </div>
                <div class="category-card">
                    <div class="category-icon">
                        <i class="bi bi-file-text"></i>
                    </div>
                    <div class="category-title">Writing & Translation</div>
                </div>
                <div class="category-card">
                    <div class="category-icon">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="category-title">Admin & Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- How it works Section -->
    <section class="how-it-works-section">
        <div class="container">
            <h2 class="section-title">How it works</h2>
            <div class="tabs">
                <button class="tab-btn active" data-tab="hiring">For hiring</button>
                <button class="tab-btn" data-tab="finding">For finding work</button>
            </div>
            <div class="steps-container">
                <div class="step-card">
                    <div class="step-icon">
                        <i class="bi bi-file-plus"></i>
                    </div>
                    <h3 class="step-title">Posting jobs is always free</h3>
                    <p class="step-description">Create your job posting and get matched with top talent</p>
                </div>
                <div class="step-card">
                    <div class="step-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="step-title">Get proposals and hire</h3>
                    <p class="step-description">Review proposals, interview candidates, and hire the best fit</p>
                </div>
                <div class="step-card">
                    <div class="step-icon">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <h3 class="step-title">Pay when work is done</h3>
                    <p class="step-description">Secure payments with milestone-based billing</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">Get insights into freelancer pricing</h2>
                <p class="cta-subtitle">Get $500 in credit when you spend $1,000 as a new Business Plus member.</p>
                <a href="{{ route('choose-role') }}" class="btn-cta">Get offer ></a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="landing-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h4 class="footer-title">For Clients</h4>
                    <ul class="footer-links">
                        <li><a href="#">How to hire</a></li>
                        <li><a href="#">Talent Marketplace</a></li>
                        <li><a href="#">Project Catalog</a></li>
                        <li><a href="#">Enterprise</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4 class="footer-title">For Talent</h4>
                    <ul class="footer-links">
                        <li><a href="#">How to find work</a></li>
                        <li><a href="#">Find freelance jobs</a></li>
                        <li><a href="#">Win work with ads</a></li>
                        <li><a href="#">Freelancer Plus</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4 class="footer-title">Resources</h4>
                    <ul class="footer-links">
                        <li><a href="#">Help & support</a></li>
                        <li><a href="#">Success stories</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Free Business Tools</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4 class="footer-title">Company</h4>
                    <ul class="footer-links">
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Contact us</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="footer-social">
                    <span>Follow us</span>
                    <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                </div>
                <div class="footer-legal">
                    <p>© 2025 Vietlance. <a href="#">Terms of Service</a> • <a href="#">Privacy Policy</a> • <a href="#">Your Privacy Choices</a></p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tab switching
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
    </body>
</html>
