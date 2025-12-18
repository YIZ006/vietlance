@extends('admin.layouts.dashboard')

@section('title', 'Thêm công việc IT')

@section('content')
<div class="dashboard-content">
    <div class="page-header">
        <h2 class="page-title">Thêm công việc IT</h2>
        <a href="{{ route('admin.it-jobs.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="content-card">
        <form action="{{ route('admin.it-jobs.store') }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="job_title">Tên Công việc <span class="required">*</span></label>
                    <input type="text" 
                           id="job_title" 
                           name="job_title" 
                           value="{{ old('job_title') }}" 
                           class="form-control @error('job_title') is-invalid @enderror"
                           placeholder="Ví dụ: Front-end Developer"
                           required>
                    @error('job_title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Danh mục <span class="required">*</span></label>
                    <select id="category_id" 
                            name="category_id" 
                            class="form-control @error('category_id') is-invalid @enderror"
                            required>
                        <option value="">Chọn danh mục</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="short_description">Mô tả ngắn</label>
                <textarea id="short_description" 
                          name="short_description" 
                          rows="3" 
                          class="form-control @error('short_description') is-invalid @enderror"
                          placeholder="Mô tả ngắn về công việc...">{{ old('short_description') }}</textarea>
                @error('short_description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Tạo công việc
                </button>
                <a href="{{ route('admin.it-jobs.index') }}" class="btn btn-secondary">
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

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
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

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
@endsection

