@extends('admin.layouts.dashboard')

@section('title', 'Thêm danh mục công việc')

@section('content')
<div class="dashboard-content">
    <div class="page-header">
        <h2 class="page-title">Thêm danh mục công việc</h2>
        <a href="{{ route('admin.job-categories.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="content-card">
        <form action="{{ route('admin.job-categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="category_name">Tên Danh mục <span class="required">*</span></label>
                <input type="text" 
                       id="category_name" 
                       name="category_name" 
                       value="{{ old('category_name') }}" 
                       class="form-control @error('category_name') is-invalid @enderror"
                       placeholder="Ví dụ: Lập trình & Phát triển phần mềm"
                       required>
                @error('category_name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Tạo danh mục
                </button>
                <a href="{{ route('admin.job-categories.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .content-card {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 500;
        color: #333;
        margin-bottom: 5px;
    }

    .required {
        color: #dc3545;
    }

    .form-control {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-control:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .error-message {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }
</style>
@endpush
@endsection

