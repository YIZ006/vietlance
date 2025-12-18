@extends('admin.layouts.dashboard')

@section('title', 'Ngôn ngữ Lập trình')

@section('content')
<div class="dashboard-content">
    <div class="page-header">
        <h2 class="page-title">Ngôn ngữ Lập trình</h2>
    </div>

    <div class="content-card">
        <!-- Search and Filter Form -->
        <form action="{{ route('admin.programming-languages.index') }}" method="GET" class="search-form">
            <div class="form-group">
                <label for="search">Tìm kiếm:</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Nhập tên ngôn ngữ hoặc danh mục..."
                       class="form-input">
            </div>
            <div class="form-group">
                <label for="category">Lọc theo danh mục:</label>
                <select id="category" 
                        name="category" 
                        class="form-input">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
                <a href="{{ route('admin.programming-languages.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i> Nhập lại
                </a>
            </div>
        </form>

        <!-- Languages by Category -->
        @foreach($languages as $category => $langs)
        <div class="category-section">
            <h3 class="category-title">
                <i class="bi bi-tag-fill"></i> {{ $category }}
                <span class="badge-count">{{ $langs->count() }}</span>
            </h3>
            <div class="languages-grid">
                @foreach($langs as $lang)
                <div class="language-card">
                    <div class="language-name">{{ $lang->name }}</div>
                    @if($lang->description)
                    <div class="language-description">{{ $lang->description }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        @if($languages->isEmpty())
        <div class="text-center" style="padding: 40px;">
            <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
            <p style="color: #666; margin-top: 15px;">Không tìm thấy ngôn ngữ nào</p>
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .page-title {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .content-card {
        background: white;
        padding: 15px 20px;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
    }

    .search-form {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 10px;
    }

    .form-group label {
        font-weight: 500;
        color: #333;
        margin-bottom: 4px;
        font-size: 13px;
    }

    .form-input {
        padding: 6px 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 13px;
    }

    .form-input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #3498db;
        color: white;
    }

    .btn-primary:hover {
        background: #2980b9;
    }

    .btn-secondary {
        background: #e74c3c;
        color: white;
    }

    .btn-secondary:hover {
        background: #c0392b;
    }

    /* Category Section */
    .category-section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #eee;
    }

    .category-section:last-child {
        border-bottom: none;
    }

    .category-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #3498db;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .category-title i {
        color: #3498db;
    }

    .badge-count {
        background-color: #3498db;
        color: white;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        margin-left: auto;
    }

    /* Languages Grid */
    .languages-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
    }

    .language-card {
        background: #f8f9fa;
        padding: 12px 15px;
        border-radius: 6px;
        border: 1px solid #e9ecef;
        transition: all 0.2s;
    }

    .language-card:hover {
        background: #e9ecef;
        border-color: #3498db;
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .language-name {
        font-weight: 600;
        color: #333;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .language-description {
        font-size: 12px;
        color: #666;
        margin-top: 4px;
    }

    .text-center {
        text-align: center;
    }

    @media (max-width: 768px) {
        .languages-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }
    }
</style>
@endpush
@endsection

