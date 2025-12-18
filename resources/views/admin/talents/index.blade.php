@extends('admin.layouts.dashboard')

@section('title', 'Quản lý Talent')

@section('content')
<div class="dashboard-content">
    <div class="page-header">
        <h2 class="page-title">Quản lý Talent</h2>
        <a href="{{ route('admin.talents.create') }}" class="btn btn-success">
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

        <!-- Search and Filter Form -->
        <form action="{{ route('admin.talents.index') }}" method="GET" class="search-form">
            <div class="form-group">
                <label for="search">Tìm kiếm:</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Nhập tên, email, kỹ năng..."
                       class="form-input">
            </div>
            <div class="form-group">
                <label for="status">Trạng thái:</label>
                <select id="status" 
                        name="status" 
                        class="form-input">
                    <option value="">Tất cả</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Tìm kiếm
                </button>
                <a href="{{ route('admin.talents.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i> Nhập lại
                </a>
            </div>
        </form>

        <!-- Talents Table -->
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                        </th>
                        <th>STT</th>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Giá/giờ</th>
                        <th>Kinh nghiệm</th>
                        <th>Trạng thái</th>
                        <th>Ngày Tạo</th>
                        <th>Profile</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($talents as $index => $talent)
                    <tr>
                        <td>
                            <input type="checkbox" class="row-checkbox" value="{{ $talent->id }}" onchange="updateBulkActions()">
                        </td>
                        <td>{{ $talents->firstItem() + $index }}</td>
                        <td>{{ $talent->id }}</td>
                        <td><strong>{{ $talent->name }}</strong></td>
                        <td>{{ $talent->email }}</td>
                        <td>{{ $talent->hourly_rate ? number_format($talent->hourly_rate, 0, ',', '.') . ' đ' : '-' }}</td>
                        <td>{{ $talent->experience_years ? $talent->experience_years . ' năm' : '-' }}</td>
                        <td>
                            @if($talent->is_active)
                            <span class="status-badge status-active">
                                <i class="bi bi-check-circle-fill"></i> Hoạt động
                            </span>
                            @else
                            <span class="status-badge status-inactive">
                                <i class="bi bi-x-circle-fill"></i> Không hoạt động
                            </span>
                            @endif
                        </td>
                        <td>{{ $talent->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($talent->profile)
                            <button type="button" 
                                    class="btn-profile" 
                                    onclick="showProfile({{ $talent->id }})"
                                    title="Xem profile">
                                <i class="bi bi-person-badge"></i> Profile
                            </button>
                            @else
                            <span class="text-muted">Chưa có</span>
                            @endif
                        </td>
                        <td class="action-column">
                            <a href="{{ route('admin.talents.edit', $talent->id) }}" class="btn-edit">
                                <i class="bi bi-pencil"></i> Sửa
                            </a>
                            <form action="{{ route('admin.talents.destroy', $talent->id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Bạn có chắc muốn xóa talent này?')">
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
                        <td colspan="11" class="text-center">Không có talent nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Info -->
        <div class="pagination-info">
            @if($talents->total() > 0)
                Hiển thị {{ $talents->firstItem() }} đến {{ $talents->lastItem() }} trong tổng số {{ $talents->total() }} bản ghi
            @else
                Không có bản ghi nào
            @endif
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $talents->links() }}
        </div>
    </div>
</div>

<!-- Bulk Delete Form -->
<form id="bulkDeleteForm" action="{{ route('admin.talents.destroy-multiple') }}" method="POST" style="display: none;">
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

    // Show profile modal
    function showProfile(talentId) {
        fetch(`{{ url('admin/talents') }}/${talentId}/profile`)
            .then(response => response.json())
            .then(data => {
                const profile = data.profile;
                const talent = data.talent;
                
                // Set modal content
                document.getElementById('profileTalentName').textContent = talent.name;
                document.getElementById('profileTalentEmail').textContent = talent.email;
                
                // Profile Overview
                document.getElementById('profileOverview').textContent = profile?.profile_overview || 'Chưa có thông tin';
                
                // Basic Information
                document.getElementById('experienceLevel').textContent = profile?.experience_level ? 
                    profile.experience_level.charAt(0).toUpperCase() + profile.experience_level.slice(1) : 'Chưa có';
                document.getElementById('hoursPerWeek').textContent = profile?.hours_per_week || 'Chưa có';
                document.getElementById('contractToHire').textContent = profile?.open_to_contract_to_hire ? 'Có' : 'Không';
                document.getElementById('visibility').textContent = profile?.visibility === 'public' ? 'Công khai' : 'Riêng tư';
                
                // Languages
                const languagesList = document.getElementById('languagesList');
                languagesList.innerHTML = '';
                if (profile?.languages && Array.isArray(profile.languages)) {
                    profile.languages.forEach(lang => {
                        const li = document.createElement('li');
                        li.textContent = `${lang.language || lang}: ${lang.level || ''}`;
                        languagesList.appendChild(li);
                    });
                } else {
                    languagesList.innerHTML = '<li>Chưa có thông tin</li>';
                }
                
                // Skills
                const skillsList = document.getElementById('skillsList');
                skillsList.innerHTML = '';
                if (profile?.skills && Array.isArray(profile.skills)) {
                    profile.skills.forEach(skill => {
                        const span = document.createElement('span');
                        span.className = 'skill-tag';
                        span.textContent = skill;
                        skillsList.appendChild(span);
                    });
                } else {
                    skillsList.innerHTML = '<span class="text-muted">Chưa có kỹ năng</span>';
                }
                
                // Verifications
                document.getElementById('idVerified').textContent = profile?.id_verified ? 'Đã xác minh ✓' : 'Chưa xác minh';
                document.getElementById('militaryVeteran').textContent = profile?.military_veteran ? 'Có' : 'Không';
                
                // Linked Accounts
                document.getElementById('githubUsername').textContent = profile?.github_username || 'Chưa có';
                document.getElementById('stackoverflowUsername').textContent = profile?.stackoverflow_username || 'Chưa có';
                document.getElementById('linkedinUrl').textContent = profile?.linkedin_url || 'Chưa có';
                document.getElementById('portfolioUrl').textContent = profile?.portfolio_url || 'Chưa có';
                
                // Certifications
                const certificationsList = document.getElementById('certificationsList');
                certificationsList.innerHTML = '';
                if (profile?.certifications && Array.isArray(profile.certifications)) {
                    profile.certifications.forEach(cert => {
                        const li = document.createElement('li');
                        li.innerHTML = `<strong>${cert.name || cert}</strong>${cert.issuer ? ' - ' + cert.issuer : ''}${cert.date ? ' (' + cert.date + ')' : ''}`;
                        certificationsList.appendChild(li);
                    });
                } else {
                    certificationsList.innerHTML = '<li>Chưa có chứng chỉ</li>';
                }
                
                // Employment History
                const employmentList = document.getElementById('employmentList');
                employmentList.innerHTML = '';
                if (profile?.employment_history && Array.isArray(profile.employment_history)) {
                    profile.employment_history.forEach(emp => {
                        const li = document.createElement('li');
                        li.innerHTML = `<strong>${emp.title || emp.position || ''}</strong> tại ${emp.company || ''}${emp.period ? ' (' + emp.period + ')' : ''}`;
                        employmentList.appendChild(li);
                    });
                } else {
                    employmentList.innerHTML = '<li>Chưa có lịch sử làm việc</li>';
                }
                
                // Education
                const educationList = document.getElementById('educationList');
                educationList.innerHTML = '';
                if (profile?.education && Array.isArray(profile.education)) {
                    profile.education.forEach(edu => {
                        const li = document.createElement('li');
                        li.innerHTML = `<strong>${edu.degree || edu.school || ''}</strong>${edu.school && edu.degree ? ' tại ' + edu.school : ''}${edu.year ? ' (' + edu.year + ')' : ''}`;
                        educationList.appendChild(li);
                    });
                } else {
                    educationList.innerHTML = '<li>Chưa có thông tin học vấn</li>';
                }
                
                // Show modal
                document.getElementById('profileModal').style.display = 'flex';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Không thể tải thông tin profile');
            });
    }

    // Close modal
    function closeProfileModal() {
        document.getElementById('profileModal').style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('profileModal');
        if (event.target == modal) {
            closeProfileModal();
        }
    }
</script>
@endpush

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
        margin-bottom: 15px;
        padding-bottom: 15px;
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
        flex-wrap: wrap;
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

    .pagination-info {
        margin-top: 15px;
        margin-bottom: 8px;
        text-align: center;
        color: #666;
        font-size: 12px;
    }

    .pagination-wrapper {
        margin-top: 8px;
        display: flex;
        justify-content: center;
        width: 100%;
        overflow-x: auto;
        padding: 8px 0;
    }
    
    .pagination-wrapper .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 5px;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }
    
    .pagination-wrapper .pagination li {
        margin: 0;
        display: flex;
        align-items: center;
    }
    
    .pagination-wrapper .pagination li a,
    .pagination-wrapper .pagination li span {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        padding: 8px 12px !important;
        margin: 0 5px !important;
        border: 1px solid #ddd !important;
        border-radius: 4px;
        color: #333 !important;
        text-decoration: none;
        background: white !important;
        transition: all 0.2s;
        min-width: 35px;
        text-align: center;
        font-size: 13px;
    }
    
    .pagination-wrapper .pagination li a:hover {
        background: #3498db !important;
        color: white !important;
        border-color: #3498db !important;
        text-decoration: none;
    }
    
    .pagination-wrapper .pagination li.active span {
        background: #3498db !important;
        color: white !important;
        border-color: #3498db !important;
        font-weight: 600;
    }
    
    .pagination-wrapper .pagination li.disabled span {
        color: #ccc;
        cursor: not-allowed;
        background-color: #f8f9fa;
        border-color: #ddd;
    }
    
    .pagination-wrapper .pagination li.disabled span:hover {
        background-color: #f8f9fa;
        color: #ccc;
        border-color: #ddd;
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

    .text-muted {
        color: #6c757d;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .status-active {
        background-color: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background-color: #f8d7da;
        color: #721c24;
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

    .btn-profile {
        padding: 6px 12px;
        background: #3498db;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-profile:hover {
        background: #2980b9;
    }

    /* Profile Modal Styles */
    .profile-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        overflow-y: auto;
    }

    .profile-modal-content {
        background-color: #fefefe;
        margin: 20px auto;
        padding: 0;
        border: none;
        border-radius: 8px;
        width: 90%;
        max-width: 1000px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }

    .profile-modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 30px;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .profile-modal-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }

    .profile-modal-close {
        color: white;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .profile-modal-close:hover {
        opacity: 0.7;
    }

    .profile-modal-body {
        padding: 30px;
    }

    .profile-section {
        margin-bottom: 30px;
        padding: 20px;
        background: white;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .profile-section-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #667eea;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile-section-title i {
        color: #667eea;
    }

    .profile-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .profile-info-item {
        display: flex;
        flex-direction: column;
    }

    .profile-info-label {
        font-weight: 600;
        color: #666;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .profile-info-value {
        color: #333;
        font-size: 14px;
    }

    .profile-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .profile-list li {
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }

    .profile-list li:last-child {
        border-bottom: none;
    }

    .skills-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .skill-tag {
        background: #e3f2fd;
        color: #1976d2;
        padding: 6px 12px;
        border-radius: 16px;
        font-size: 13px;
        font-weight: 500;
    }

    .text-muted {
        color: #999;
        font-style: italic;
    }
</style>
@endpush

<!-- Profile Modal -->
<div id="profileModal" class="profile-modal">
    <div class="profile-modal-content">
        <div class="profile-modal-header">
            <h2><i class="bi bi-person-badge"></i> Profile Chi Tiết</h2>
            <button class="profile-modal-close" onclick="closeProfileModal()">&times;</button>
        </div>
        <div class="profile-modal-body">
            <!-- Talent Info -->
            <div class="profile-section">
                <div class="profile-section-title">
                    <i class="bi bi-person"></i> Thông tin Talent
                </div>
                <div class="profile-info-grid">
                    <div class="profile-info-item">
                        <span class="profile-info-label">Tên:</span>
                        <span class="profile-info-value" id="profileTalentName">-</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-label">Email:</span>
                        <span class="profile-info-value" id="profileTalentEmail">-</span>
                    </div>
                </div>
            </div>

            <!-- Profile Overview -->
            <div class="profile-section">
                <div class="profile-section-title">
                    <i class="bi bi-file-text"></i> Tổng quan Profile
                </div>
                <p id="profileOverview" style="line-height: 1.6; color: #555;">Chưa có thông tin</p>
            </div>

            <!-- Basic Information -->
            <div class="profile-section">
                <div class="profile-section-title">
                    <i class="bi bi-info-circle"></i> Thông tin Cơ bản
                </div>
                <div class="profile-info-grid">
                    <div class="profile-info-item">
                        <span class="profile-info-label">Mức độ Kinh nghiệm:</span>
                        <span class="profile-info-value" id="experienceLevel">Chưa có</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-label">Số giờ/tuần:</span>
                        <span class="profile-info-value" id="hoursPerWeek">Chưa có</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-label">Sẵn sàng hợp đồng thuê:</span>
                        <span class="profile-info-value" id="contractToHire">Không</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-label">Hiển thị:</span>
                        <span class="profile-info-value" id="visibility">Công khai</span>
                    </div>
                </div>
            </div>

            <!-- Languages -->
            <div class="profile-section">
                <div class="profile-section-title">
                    <i class="bi bi-translate"></i> Ngôn ngữ
                </div>
                <ul class="profile-list" id="languagesList">
                    <li>Chưa có thông tin</li>
                </ul>
            </div>

            <!-- Skills -->
            <div class="profile-section">
                <div class="profile-section-title">
                    <i class="bi bi-tools"></i> Kỹ năng
                </div>
                <div class="skills-container" id="skillsList">
                    <span class="text-muted">Chưa có kỹ năng</span>
                </div>
            </div>

            <!-- Verifications -->
            <div class="profile-section">
                <div class="profile-section-title">
                    <i class="bi bi-shield-check"></i> Xác minh
                </div>
                <div class="profile-info-grid">
                    <div class="profile-info-item">
                        <span class="profile-info-label">Xác minh ID:</span>
                        <span class="profile-info-value" id="idVerified">Chưa xác minh</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-label">Cựu quân nhân:</span>
                        <span class="profile-info-value" id="militaryVeteran">Không</span>
                    </div>
                </div>
            </div>

            <!-- Linked Accounts -->
            <div class="profile-section">
                <div class="profile-section-title">
                    <i class="bi bi-link-45deg"></i> Tài khoản Liên kết
                </div>
                <div class="profile-info-grid">
                    <div class="profile-info-item">
                        <span class="profile-info-label">GitHub:</span>
                        <span class="profile-info-value" id="githubUsername">Chưa có</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-label">StackOverflow:</span>
                        <span class="profile-info-value" id="stackoverflowUsername">Chưa có</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-label">LinkedIn:</span>
                        <span class="profile-info-value" id="linkedinUrl">Chưa có</span>
                    </div>
                    <div class="profile-info-item">
                        <span class="profile-info-label">Portfolio:</span>
                        <span class="profile-info-value" id="portfolioUrl">Chưa có</span>
                    </div>
                </div>
            </div>

            <!-- Certifications -->
            <div class="profile-section">
                <div class="profile-section-title">
                    <i class="bi bi-award"></i> Chứng chỉ
                </div>
                <ul class="profile-list" id="certificationsList">
                    <li>Chưa có chứng chỉ</li>
                </ul>
            </div>

            <!-- Employment History -->
            <div class="profile-section">
                <div class="profile-section-title">
                    <i class="bi bi-briefcase"></i> Lịch sử Làm việc
                </div>
                <ul class="profile-list" id="employmentList">
                    <li>Chưa có lịch sử làm việc</li>
                </ul>
            </div>

            <!-- Education -->
            <div class="profile-section">
                <div class="profile-section-title">
                    <i class="bi bi-mortarboard"></i> Học vấn
                </div>
                <ul class="profile-list" id="educationList">
                    <li>Chưa có thông tin học vấn</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection




