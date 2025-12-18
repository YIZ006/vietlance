@extends('admin.layouts.dashboard')

@section('title', 'Quản lý tài khoản quản trị')

@section('content')
<div class="dashboard-content">
    <div class="page-header">
        <h2 class="page-title">Quản lý tài khoản quản trị</h2>
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
        <!-- Search Form -->
        <form action="{{ route('admin.accounts.index') }}" method="GET" class="search-form">
            <div class="form-group">
                <label for="search">Tìm kiếm admin:</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Nhập tên, email, số điện thoại, quyền..."
                       class="form-input">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
                <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i> Nhập lại
                </a>
            </div>
        </form>

        <!-- Bảng Superadmin -->
        <div class="role-section">
            <h3 class="role-section-title">
                <i class="bi bi-shield-fill"></i> Superadmin
                <span class="badge-count">({{ $superadmins->count() }})</span>
            </h3>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>ID</th>
                            <th>Admin Login</th>
                            <th>Họ Tên</th>
                            <th>Email</th>
                            <th>Điện Thoại</th>
                            <th>Ngày Tạo</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($superadmins as $index => $admin)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->admin_login }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->phone ?? '-' }}</td>
                            <td>{{ $admin->created_at->format('d/m/Y') }}</td>
                            <td class="status-column">
                                @if($admin->status === 'active')
                                    <span class="status-badge status-active" title="Đang hoạt động">
                                        <i class="bi bi-check-circle-fill"></i> Active
                                    </span>
                                @elseif($admin->status === 'locked')
                                    <span class="status-badge status-locked" title="Đã khóa">
                                        <i class="bi bi-lock-fill"></i> Locked
                                    </span>
                                @else
                                    <span class="status-badge status-inactive" title="Không hoạt động">
                                        <i class="bi bi-x-circle-fill"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="action-column">
                                @if($isSuperAdmin || $currentAdmin->id == $admin->id)
                                    <a href="{{ route('admin.accounts.edit', $admin->id) }}" class="btn-edit">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Không có Superadmin nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bảng Admin -->
        <div class="role-section">
            <h3 class="role-section-title">
                <i class="bi bi-person-badge-fill"></i> Admin
                <span class="badge-count">({{ $admins->count() }})</span>
            </h3>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>ID</th>
                            <th>Admin Login</th>
                            <th>Họ Tên</th>
                            <th>Email</th>
                            <th>Điện Thoại</th>
                            <th>Ngày Tạo</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $index => $admin)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->admin_login }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->phone ?? '-' }}</td>
                            <td>{{ $admin->created_at->format('d/m/Y') }}</td>
                            <td class="status-column">
                                @if($isSuperAdmin && $currentAdmin->id != $admin->id)
                                    @if($admin->status === 'locked')
                                        <a href="{{ route('admin.accounts.toggle-lock', $admin->id) }}" 
                                           class="lock-btn unlock-btn" 
                                           title="Tài khoản đang bị khóa - Click để mở khóa"
                                           onclick="return confirm('Bạn có chắc muốn mở khóa tài khoản này?')">
                                            <i class="bi bi-lock-fill"></i> <span>Đang khóa</span> - Mở khóa
                                        </a>
                                    @else
                                        <a href="{{ route('admin.accounts.toggle-lock', $admin->id) }}" 
                                           class="lock-btn lock-action-btn" 
                                           title="Tài khoản đang hoạt động - Click để khóa"
                                           onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?')">
                                            <i class="bi bi-unlock-fill"></i> <span>Đang hoạt động</span> - Khóa
                                        </a>
                                    @endif
                                @else
                                    @if($admin->status === 'active')
                                        <span class="status-badge status-active" title="Đang hoạt động">
                                            <i class="bi bi-check-circle-fill"></i> Active
                                        </span>
                                    @elseif($admin->status === 'locked')
                                        <span class="status-badge status-locked" title="Đã khóa">
                                            <i class="bi bi-lock-fill"></i> Locked
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive" title="Không hoạt động">
                                            <i class="bi bi-x-circle-fill"></i> Inactive
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="action-column">
                                @if($isSuperAdmin || $currentAdmin->id == $admin->id)
                                    <a href="{{ route('admin.accounts.edit', $admin->id) }}" class="btn-edit">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                @endif
                                @if($isSuperAdmin && $currentAdmin->id != $admin->id)
                                    <form action="{{ route('admin.accounts.destroy', $admin->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Không có Admin nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bảng Viewer -->
        <div class="role-section">
            <h3 class="role-section-title">
                <i class="bi bi-eye-fill"></i> Viewer
                <span class="badge-count">({{ $viewers->count() }})</span>
            </h3>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>ID</th>
                            <th>Admin Login</th>
                            <th>Họ Tên</th>
                            <th>Email</th>
                            <th>Điện Thoại</th>
                            <th>Ngày Tạo</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($viewers as $index => $admin)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->admin_login }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->phone ?? '-' }}</td>
                            <td>{{ $admin->created_at->format('d/m/Y') }}</td>
                            <td class="status-column">
                                @if(($isSuperAdmin || $currentAdmin->isAdmin()) && $currentAdmin->id != $admin->id)
                                    @if($admin->status === 'locked')
                                        <a href="{{ route('admin.accounts.toggle-lock', $admin->id) }}" 
                                           class="lock-btn unlock-btn" 
                                           title="Tài khoản đang bị khóa - Click để mở khóa"
                                           onclick="return confirm('Bạn có chắc muốn mở khóa tài khoản này?')">
                                            <i class="bi bi-lock-fill"></i> <span>Đang khóa</span> - Mở khóa
                                        </a>
                                    @else
                                        <a href="{{ route('admin.accounts.toggle-lock', $admin->id) }}" 
                                           class="lock-btn lock-action-btn" 
                                           title="Tài khoản đang hoạt động - Click để khóa"
                                           onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?')">
                                            <i class="bi bi-unlock-fill"></i> <span>Đang hoạt động</span> - Khóa
                                        </a>
                                    @endif
                                @else
                                    @if($admin->status === 'active')
                                        <span class="status-badge status-active" title="Đang hoạt động">
                                            <i class="bi bi-check-circle-fill"></i> Active
                                        </span>
                                    @elseif($admin->status === 'locked')
                                        <span class="status-badge status-locked" title="Đã khóa">
                                            <i class="bi bi-lock-fill"></i> Locked
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive" title="Không hoạt động">
                                            <i class="bi bi-x-circle-fill"></i> Inactive
                                        </span>
                                    @endif
                                @endif
                            </td>
                            <td class="action-column">
                                @if($isSuperAdmin || $currentAdmin->id == $admin->id)
                                    <a href="{{ route('admin.accounts.edit', $admin->id) }}" class="btn-edit">
                                        <i class="bi bi-pencil"></i> Sửa
                                    </a>
                                @endif
                                @if($isSuperAdmin && $currentAdmin->id != $admin->id)
                                    <form action="{{ route('admin.accounts.destroy', $admin->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">
                                            <i class="bi bi-trash"></i> Xóa
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Không có Viewer nào</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form thêm mới admin (hiện với superadmin và admin) -->
        @if($isSuperAdmin || $currentAdmin->isAdmin())
        <div class="add-admin-section">
            <h3 class="section-title">Thêm tài khoản mới</h3>
            <form action="{{ route('admin.accounts.store') }}" method="POST" class="add-admin-form">
                @csrf
                <div class="form-row-small">
                    <div class="form-group-small">
                        <label for="new_name">Họ Tên <span class="required">*</span></label>
                        <input type="text" 
                               id="new_name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               class="form-control-small @error('name') is-invalid @enderror"
                               required>
                        @error('name')
                            <div class="error-message-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group-small">
                        <label for="new_admin_login">Admin Login <span class="required">*</span></label>
                        <input type="text" 
                               id="new_admin_login" 
                               name="admin_login" 
                               value="{{ old('admin_login') }}" 
                               class="form-control-small @error('admin_login') is-invalid @enderror"
                               required>
                        @error('admin_login')
                            <div class="error-message-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group-small">
                        <label for="new_email">Email <span class="required">*</span></label>
                        <input type="email" 
                               id="new_email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               class="form-control-small @error('email') is-invalid @enderror"
                               required>
                        @error('email')
                            <div class="error-message-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group-small">
                        <label for="new_phone">Điện Thoại</label>
                        <input type="text" 
                               id="new_phone" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               class="form-control-small @error('phone') is-invalid @enderror">
                        @error('phone')
                            <div class="error-message-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group-small">
                        <label for="new_password">Mật khẩu <span class="required">*</span></label>
                        <input type="password" 
                               id="new_password" 
                               name="password" 
                               class="form-control-small @error('password') is-invalid @enderror"
                               required>
                        @error('password')
                            <div class="error-message-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group-small">
                        <label for="new_password_confirmation">Xác nhận mật khẩu <span class="required">*</span></label>
                        <input type="password" 
                               id="new_password_confirmation" 
                               name="password_confirmation" 
                               class="form-control-small"
                               required>
                    </div>

                    <div class="form-group-small">
                        <label for="new_role">Role <span class="required">*</span></label>
                        <select id="new_role" 
                                name="role" 
                                class="form-control-small @error('role') is-invalid @enderror"
                                required>
                            @if($isSuperAdmin)
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            @endif
                            <option value="viewer" {{ old('role') == 'viewer' ? 'selected' : '' }}>Viewer</option>
                        </select>
                        @error('role')
                            <div class="error-message-small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions-small">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle"></i> Create
                    </button>
                    <button type="reset" class="btn btn-secondary btn-sm">
                        <i class="bi bi-x-circle"></i> Reset
                    </button>
                </div>
            </form>
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

    .search-form {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .form-group {
        display: flex;
        gap: 10px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .form-group label {
        font-weight: 500;
        color: #333;
        margin-bottom: 5px;
        width: 100%;
    }

    .form-input {
        flex: 1;
        min-width: 250px;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .btn {
        padding: 8px 16px;
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

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .table-responsive {
        overflow-x: auto;
        margin-top: 20px;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }

    .admin-table thead {
        background-color: #34495e;
        color: white;
    }

    .admin-table th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
    }

    .admin-table td {
        padding: 12px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    .admin-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .status-column {
        text-align: center;
    }

    .lock-btn {
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 4px;
        transition: all 0.2s;
        font-weight: 500;
    }

    .lock-btn span {
        font-weight: 600;
    }

    .lock-action-btn {
        color: #856404;
        background-color: #fff3cd;
        border: 1px solid #ffc107;
    }

    .lock-action-btn:hover {
        background-color: #ffc107;
        color: #856404;
    }

    .unlock-btn {
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #dc3545;
    }

    .unlock-btn:hover {
        background-color: #dc3545;
        color: white;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .status-active {
        background-color: #d4edda;
        color: #155724;
    }

    .status-locked {
        background-color: #f8d7da;
        color: #721c24;
    }

    .status-inactive {
        background-color: #fff3cd;
        color: #856404;
    }

    .action-column {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn-edit {
        color: #007bff;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-edit:hover {
        text-decoration: underline;
    }

    .btn-delete {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        font-size: 14px;
        padding: 0;
    }

    .btn-delete:hover {
        text-decoration: underline;
    }

    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
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

    .text-danger {
        color: #dc3545;
    }

    .text-success {
        color: #28a745;
    }

    /* Role Section */
    .role-section {
        margin-bottom: 40px;
    }

    .role-section-title {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 3px solid #34495e;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .role-section-title i {
        font-size: 24px;
    }

    .role-section:first-of-type .role-section-title {
        border-bottom-color: #dc3545; /* Đỏ cho Superadmin */
    }

    .role-section:nth-of-type(2) .role-section-title {
        border-bottom-color: #007bff; /* Xanh cho Admin */
    }

    .role-section:nth-of-type(3) .role-section-title {
        border-bottom-color: #6c757d; /* Xám cho Viewer */
    }

    .badge-count {
        background-color: #34495e;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        margin-left: auto;
    }

    /* Form thêm mới admin */
    .add-admin-section {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #eee;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
    }

    .add-admin-form {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .form-row-small {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }

    .form-group-small {
        display: flex;
        flex-direction: column;
    }

    .form-group-small label {
        font-size: 13px;
        font-weight: 500;
        color: #333;
        margin-bottom: 5px;
    }

    .form-control-small {
        padding: 6px 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 13px;
    }

    .form-control-small:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
    }

    .form-control-small.is-invalid {
        border-color: #dc3545;
    }

    .error-message-small {
        color: #dc3545;
        font-size: 11px;
        margin-top: 3px;
    }

    .form-actions-small {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .form-row-small {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
@endsection

