@extends('admin.layouts.dashboard')

@section('title', 'Quản lý Danh mục Công việc')

@section('content')
<div class="dashboard-content">
    <div class="page-header">
        <h2 class="page-title">Quản lý Danh mục Công việc</h2>
        <a href="{{ route('admin.job-categories.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Thêm mới
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    <div class="content-card">
        <!-- Bulk Actions -->
        <div class="bulk-actions-bar" id="bulkActionsBar" style="display: none;">
            <div class="bulk-actions-info">
                <span id="selectedCount">0</span> bản ghi đã được chọn
            </div>
            <button type="button" class="btn btn-danger" id="bulkDeleteBtn" onclick="bulkDelete()">
                <i class="bi bi-trash"></i> Xóa đã chọn
            </button>
            <button type="button" class="btn btn-secondary" onclick="clearSelection()">
                <i class="bi bi-x-circle"></i> Bỏ chọn
            </button>
        </div>

        <!-- Search Form -->
        <form action="{{ route('admin.job-categories.index') }}" method="GET" class="search-form">
            <div class="form-group">
                <label for="search">Tìm kiếm danh mục:</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Nhập tên danh mục..."
                       class="form-input">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
                <a href="{{ route('admin.job-categories.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i> Nhập lại
                </a>
            </div>
        </form>

        <!-- Categories Table -->
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                        </th>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Tên Danh mục</th>
                        <th>Số lượng Công việc</th>
                        <th>Ngày Tạo</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                    <tr>
                        <td>
                            <input type="checkbox" class="row-checkbox" value="{{ $category->category_id }}" onchange="updateBulkActions()">
                        </td>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $category->category_id }}</td>
                        <td><strong>{{ $category->category_name }}</strong></td>
                        <td>
                            <span class="badge-count">{{ $category->jobs_count }}</span>
                        </td>
                        <td>{{ $category->created_at->format('d/m/Y') }}</td>
                        <td class="action-column">
                            <a href="{{ route('admin.job-categories.edit', $category->category_id) }}" class="btn-edit">
                                <i class="bi bi-pencil"></i> Sửa
                            </a>
                            <form action="{{ route('admin.job-categories.destroy', $category->category_id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Bạn có chắc muốn xóa danh mục này? Tất cả công việc thuộc danh mục sẽ bị xóa category_id.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <i class="bi bi-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Không có danh mục nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bulk Delete Form -->
<form id="bulkDeleteForm" action="{{ route('admin.job-categories.destroy-multiple') }}" method="POST" style="display: none;">
    @csrf
    @method('POST')
    <input type="hidden" name="ids" id="bulkDeleteIds">
</form>

@push('scripts')
<script>
    function toggleSelectAll(checkbox) {
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        rowCheckboxes.forEach(cb => {
            cb.checked = checkbox.checked;
        });
        updateBulkActions();
    }

    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const bulkActionsBar = document.getElementById('bulkActionsBar');
        const selectedCount = document.getElementById('selectedCount');
        const selectAllCheckbox = document.getElementById('selectAll');

        if (checkedBoxes.length > 0) {
            bulkActionsBar.style.display = 'flex';
            selectedCount.textContent = checkedBoxes.length;
        } else {
            bulkActionsBar.style.display = 'none';
        }

        // Update select all checkbox state
        const allChecked = checkedBoxes.length === document.querySelectorAll('.row-checkbox').length;
        const someChecked = checkedBoxes.length > 0;
        selectAllCheckbox.checked = allChecked;
        selectAllCheckbox.indeterminate = someChecked && !allChecked;
    }

    function clearSelection() {
        document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;
        document.getElementById('selectAll').indeterminate = false;
        updateBulkActions();
    }

    function bulkDelete() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        if (checkedBoxes.length === 0) {
            alert('Vui lòng chọn ít nhất một bản ghi để xóa!');
            return;
        }

        if (!confirm(`Bạn có chắc muốn xóa ${checkedBoxes.length} bản ghi đã chọn?`)) {
            return;
        }

        const ids = Array.from(checkedBoxes).map(cb => cb.value);
        document.getElementById('bulkDeleteIds').value = JSON.stringify(ids);
        document.getElementById('bulkDeleteForm').submit();
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateBulkActions();
    });
</script>
@endpush

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
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .search-form {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .form-group {
        display: flex;
        gap: 8px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .form-group label {
        font-weight: 500;
        color: #333;
        margin-bottom: 4px;
        width: 100%;
        font-size: 13px;
    }

    .form-input {
        flex: 1;
        min-width: 250px;
        padding: 6px 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 13px;
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

    .btn-success {
        background: #2ecc71;
        color: white;
    }

    .btn-success:hover {
        background: #27ae60;
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

    .table-responsive {
        overflow-x: auto;
        margin-top: 15px;
        width: 100%;
        -webkit-overflow-scrolling: touch;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        margin: 0 auto;
        table-layout: auto;
    }

    .admin-table thead {
        background-color: #34495e;
        color: white;
    }

    .admin-table th {
        padding: 10px 12px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
    }

    .admin-table td {
        padding: 10px 12px;
        border-bottom: 1px solid #eee;
        font-size: 13px;
    }

    .admin-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .action-column {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn-edit {
        padding: 6px 12px;
        background: #f1c40f;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 13px;
        white-space: nowrap;
        border: none;
        cursor: pointer;
        display: inline-block;
    }

    .btn-edit:hover {
        background: #f39c12;
        color: white;
    }

    .btn-delete {
        padding: 6px 12px;
        background: #e74c3c;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        white-space: nowrap;
    }

    .btn-delete:hover {
        background: #c0392b;
    }

    .alert {
        padding: 12px 20px;
        border-radius: 4px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .text-center {
        text-align: center;
    }

    .badge-count {
        background-color: #007bff;
        color: white;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Bulk Actions Bar */
    .bulk-actions-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 15px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        margin-bottom: 15px;
        gap: 10px;
        font-size: 13px;
    }

    .bulk-actions-info {
        flex: 1;
        font-weight: 500;
        color: #333;
        font-size: 13px;
    }

    .bulk-actions-bar .btn {
        margin: 0;
        padding: 6px 12px;
        font-size: 13px;
    }

    .bulk-actions-bar .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .bulk-actions-bar .btn-danger:hover {
        background-color: #c82333;
    }

    /* Checkbox styling */
    input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #007bff;
    }

    .admin-table th:first-child,
    .admin-table td:first-child {
        text-align: center;
        width: 50px;
    }
</style>
@endpush
@endsection

