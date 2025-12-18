<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminAccessController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\JobCategoryController;
use App\Http\Controllers\Admin\ItJobController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\TalentController;
use App\Http\Controllers\Admin\ProgrammingLanguageController;
use App\Http\Controllers\Talent\Auth\TalentLoginController;
use App\Http\Controllers\Talent\Auth\TalentRegisterController;
use App\Http\Controllers\Freelance\Auth\FreelanceRegisterController;
use App\Http\Controllers\Client\Auth\ClientLoginController;
use App\Http\Controllers\Client\Auth\ClientRegisterController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/choose-role', function () {
    return view('choose-role');
})->name('choose-role');

// Route ẩn để truy cập admin (không hiển thị "admin" trong URL)
Route::get('/cp', [AdminAccessController::class, 'access'])->name('admin.access');
Route::get('/panel', [AdminAccessController::class, 'access'])->name('admin.panel');
Route::get('/manage', [AdminAccessController::class, 'access'])->name('admin.manage');

// Admin Routes (đường dẫn gốc vẫn hoạt động)
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes (chưa đăng nhập)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
    });

    // Authenticated routes (đã đăng nhập)
    Route::middleware('auth:admin')->group(function () {
        // Dashboard với đường dẫn khó đoán
        Route::get('/dashboard/x7k9m2p4q6r8s1t3v5w7y9z0a2b4c6d8e0', [AdminDashboardController::class, 'index'])->name('dashboard.secure');
        
        // Dashboard thông thường (giữ lại để tương thích)
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Các trang khác
        Route::get('/policies/x9k2m5p8q1r4s7t0v3w6y9z2a5b8c1d4e7', [AdminDashboardController::class, 'policies'])->name('policies');
        Route::get('/contact/x3k6m9p2q5r8s1t4v7w0y3z6a9b2c5d8e1', [AdminDashboardController::class, 'contact'])->name('contact');
        
        // Quản lý tài khoản admin
        Route::prefix('accounts')->name('accounts.')->group(function () {
            Route::get('/', [AdminAccountController::class, 'index'])->name('index');
            Route::get('/create', [AdminAccountController::class, 'create'])->name('create');
            Route::post('/', [AdminAccountController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminAccountController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminAccountController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminAccountController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/toggle-lock', [AdminAccountController::class, 'toggleLock'])->name('toggle-lock');
        });

        // Quản lý danh mục công việc
        Route::prefix('job-categories')->name('job-categories.')->group(function () {
            Route::get('/', [JobCategoryController::class, 'index'])->name('index');
            Route::get('/create', [JobCategoryController::class, 'create'])->name('create');
            Route::post('/', [JobCategoryController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [JobCategoryController::class, 'edit'])->name('edit');
            Route::put('/{id}', [JobCategoryController::class, 'update'])->name('update');
            Route::delete('/{id}', [JobCategoryController::class, 'destroy'])->name('destroy');
            Route::post('/delete-multiple', [JobCategoryController::class, 'destroyMultiple'])->name('destroy-multiple');
        });

        // Quản lý công việc IT
        Route::prefix('it-jobs')->name('it-jobs.')->group(function () {
            Route::get('/', [ItJobController::class, 'index'])->name('index');
            Route::get('/create', [ItJobController::class, 'create'])->name('create');
            Route::post('/', [ItJobController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ItJobController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ItJobController::class, 'update'])->name('update');
            Route::delete('/{id}', [ItJobController::class, 'destroy'])->name('destroy');
            Route::post('/delete-multiple', [ItJobController::class, 'destroyMultiple'])->name('destroy-multiple');
        });

        // Quản lý Khách hàng
        Route::prefix('clients')->name('clients.')->group(function () {
            Route::get('/', [ClientController::class, 'index'])->name('index');
            Route::get('/create', [ClientController::class, 'create'])->name('create');
            Route::post('/', [ClientController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ClientController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ClientController::class, 'update'])->name('update');
            Route::delete('/{id}', [ClientController::class, 'destroy'])->name('destroy');
            Route::post('/delete-multiple', [ClientController::class, 'destroyMultiple'])->name('destroy-multiple');
        });

        // Quản lý Talent
        Route::prefix('talents')->name('talents.')->group(function () {
            Route::get('/', [TalentController::class, 'index'])->name('index');
            Route::get('/create', [TalentController::class, 'create'])->name('create');
            Route::post('/', [TalentController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [TalentController::class, 'edit'])->name('edit');
            Route::put('/{id}', [TalentController::class, 'update'])->name('update');
            Route::delete('/{id}', [TalentController::class, 'destroy'])->name('destroy');
            Route::post('/delete-multiple', [TalentController::class, 'destroyMultiple'])->name('destroy-multiple');
            Route::get('/{id}/profile', [TalentController::class, 'getProfile'])->name('profile');
        });

        // Ngôn ngữ Lập trình (chỉ hiển thị, không quản lý)
        Route::get('/programming-languages', [ProgrammingLanguageController::class, 'index'])->name('programming-languages.index');

        // Tạo dữ liệu mẫu (chỉ Superadmin)
        Route::prefix('seed-data')->name('seed-data.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\SeedDataController::class, 'index'])->name('index');
            Route::post('/seed-all', [\App\Http\Controllers\Admin\SeedDataController::class, 'seedAll'])->name('seed-all');
            Route::post('/seed-specific', [\App\Http\Controllers\Admin\SeedDataController::class, 'seedSpecific'])->name('seed-specific');
        });
        
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    });
});

// Talent Routes
Route::prefix('talent')->name('talent.')->group(function () {
    // Guest routes (chưa đăng nhập)
    Route::middleware('guest:talent')->group(function () {
        // Login routes
        Route::get('/login', [TalentLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [TalentLoginController::class, 'login']);
        
        // Register routes
        Route::get('/register', [TalentRegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [TalentRegisterController::class, 'register']);
        
        // Google OAuth routes
        Route::get('/auth/google', [TalentLoginController::class, 'redirectToGoogle'])->name('google.redirect');
        Route::get('/auth/google/callback', [TalentLoginController::class, 'handleGoogleCallback'])->name('google.callback');
        
        // GitHub OAuth routes
        Route::get('/auth/github', [TalentLoginController::class, 'redirectToGithub'])->name('github.redirect');
        Route::get('/auth/github/callback', [TalentLoginController::class, 'handleGithubCallback'])->name('github.callback');
        
        // Magic link routes
        Route::post('/login/magic-link', [TalentLoginController::class, 'sendMagicLink'])->name('magic-link.send');
        Route::get('/login/magic/{token}', [TalentLoginController::class, 'loginWithMagicLink'])->name('magic-link.login');
    });

    // Authenticated routes (đã đăng nhập)
    Route::middleware('auth:talent')->group(function () {
        Route::get('/dashboard', function () {
            return view('talent.dashboard');
        })->name('dashboard');
        Route::post('/logout', [TalentLoginController::class, 'logout'])->name('logout');
    });
});

// Client Routes
Route::prefix('client')->name('client.')->group(function () {
    // Guest routes (chưa đăng nhập)
    Route::middleware('guest:client')->group(function () {
        // Login routes
        Route::get('/login', [ClientLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [ClientLoginController::class, 'login']);
        
        // Register routes
        Route::get('/register', [ClientRegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('/register', [ClientRegisterController::class, 'register']);
        
        // Google OAuth routes
        Route::get('/auth/google', [ClientLoginController::class, 'redirectToGoogle'])->name('google.redirect');
        Route::get('/auth/google/callback', [ClientLoginController::class, 'handleGoogleCallback'])->name('google.callback');
        
        // Magic link routes
        Route::post('/login/magic-link', [ClientLoginController::class, 'sendMagicLink'])->name('magic-link.send');
        Route::get('/login/magic/{token}', [ClientLoginController::class, 'loginWithMagicLink'])->name('magic-link.login');
    });

    // Authenticated routes (đã đăng nhập)
    Route::middleware('auth:client')->group(function () {
        Route::get('/dashboard', function () {
            return view('client.dashboard');
        })->name('dashboard');
        Route::post('/logout', [ClientLoginController::class, 'logout'])->name('logout');
    });
});
