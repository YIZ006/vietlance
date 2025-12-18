@extends('admin.layouts.dashboard')

@section('title', 'Tạo dữ liệu mẫu')

@section('content')
<div class="dashboard-content">
    <div class="page-header mb-3">
        <h2><i class="bi bi-database-add"></i> Tạo dữ liệu mẫu</h2>
        <p class="text-muted">Chức năng này cho phép tạo dữ liệu mẫu cho tất cả các bảng trong hệ thống. Chỉ Superadmin mới có quyền sử dụng.</p>
    </div>

    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> <strong>Lưu ý:</strong> Chức năng này sẽ tạo dữ liệu mẫu cho các bảng. Nếu dữ liệu đã tồn tại (dựa trên email hoặc ID), hệ thống sẽ bỏ qua để tránh trùng lặp.
    </div>

    <!-- Seed All Button -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-stars"></i> Tạo tất cả dữ liệu mẫu
                <span class="badge bg-light text-dark ms-2">Dữ liệu mẫu</span>
            </h5>
        </div>
        <div class="card-body">
            <p>Tạo dữ liệu mẫu cho tất cả các bảng trong hệ thống:</p>
            <ul class="list-unstyled">
                <li><i class="bi bi-check-circle text-success"></i> Admin (Superadmin, Admin, Viewer)</li>
                <li><i class="bi bi-check-circle text-success"></i> Talent</li>
                <li><i class="bi bi-check-circle text-success"></i> Client</li>
                <li><i class="bi bi-check-circle text-success"></i> Job Categories</li>
                <li><i class="bi bi-check-circle text-success"></i> IT Jobs</li>
                <li><i class="bi bi-check-circle text-success"></i> Programming Languages</li>
                <li><i class="bi bi-check-circle text-success"></i> Profiles (cho Talent)</li>
            </ul>
            <button type="button" class="btn btn-primary btn-lg" id="seedAllBtn">
                <i class="bi bi-stars"></i> Tạo tất cả dữ liệu mẫu
            </button>
        </div>
    </div>

    <!-- Individual Seed Options -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-person-badge"></i> Admin
                        <span class="badge bg-light text-dark ms-2">Dữ liệu mẫu</span>
                    </h6>
                </div>
                <div class="card-body">
                    <p class="card-text">Tạo dữ liệu mẫu cho bảng Admin (Superadmin, Admin, Viewer)</p>
                    <button type="button" class="btn btn-success seed-specific-btn" data-type="admins">
                        <i class="bi bi-plus-circle"></i> Tạo Admin
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-person-workspace"></i> Talent
                        <span class="badge bg-light text-dark ms-2">Dữ liệu mẫu</span>
                    </h6>
                </div>
                <div class="card-body">
                    <p class="card-text">Tạo dữ liệu mẫu cho bảng Talent</p>
                    <button type="button" class="btn btn-info seed-specific-btn" data-type="talents">
                        <i class="bi bi-plus-circle"></i> Tạo Talent
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="bi bi-people"></i> Client
                        <span class="badge bg-dark text-white ms-2">Dữ liệu mẫu</span>
                    </h6>
                </div>
                <div class="card-body">
                    <p class="card-text">Tạo dữ liệu mẫu cho bảng Client</p>
                    <button type="button" class="btn btn-warning seed-specific-btn" data-type="clients">
                        <i class="bi bi-plus-circle"></i> Tạo Client
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-list-ul"></i> Job Categories
                        <span class="badge bg-light text-dark ms-2">Dữ liệu mẫu</span>
                    </h6>
                </div>
                <div class="card-body">
                    <p class="card-text">Tạo dữ liệu mẫu cho bảng Job Categories</p>
                    <button type="button" class="btn btn-secondary seed-specific-btn" data-type="job_categories">
                        <i class="bi bi-plus-circle"></i> Tạo Job Categories
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-briefcase-fill"></i> IT Jobs
                        <span class="badge bg-light text-dark ms-2">Dữ liệu mẫu</span>
                    </h6>
                </div>
                <div class="card-body">
                    <p class="card-text">Tạo dữ liệu mẫu cho bảng IT Jobs</p>
                    <button type="button" class="btn btn-dark seed-specific-btn" data-type="it_jobs">
                        <i class="bi bi-plus-circle"></i> Tạo IT Jobs
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header" style="background-color: #6f42c1; color: white;">
                    <h6 class="mb-0">
                        <i class="bi bi-code-square"></i> Programming Languages
                        <span class="badge bg-light text-dark ms-2">Dữ liệu mẫu</span>
                    </h6>
                </div>
                <div class="card-body">
                    <p class="card-text">Tạo dữ liệu mẫu cho bảng Programming Languages</p>
                    <button type="button" class="btn seed-specific-btn" data-type="programming_languages" style="background-color: #6f42c1; color: white;">
                        <i class="bi bi-plus-circle"></i> Tạo Programming Languages
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-header" style="background-color: #20c997; color: white;">
                    <h6 class="mb-0">
                        <i class="bi bi-file-person"></i> Profiles
                        <span class="badge bg-light text-dark ms-2">Dữ liệu mẫu</span>
                    </h6>
                </div>
                <div class="card-body">
                    <p class="card-text">Tạo dữ liệu mẫu cho bảng Profiles (cho các Talent)</p>
                    <button type="button" class="btn seed-specific-btn" data-type="profiles" style="background-color: #20c997; color: white;">
                        <i class="bi bi-plus-circle"></i> Tạo Profiles
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Đang xử lý</h5>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="spinner-border text-light mb-3" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mb-0">Đang tạo dữ liệu mẫu, vui lòng đợi...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));

    // Custom Confirm Dialog
    function showCustomConfirm(message, callback) {
        const modal = document.createElement('div');
        modal.className = 'modal fade show';
        modal.style.display = 'block';
        modal.style.zIndex = '1055';
        
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        backdrop.style.zIndex = '1050';
        document.body.appendChild(backdrop);
        
        modal.innerHTML = `
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xác nhận</h5>
                        <button type="button" class="btn-close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>${message}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" data-confirm="true">Xác nhận</button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        document.body.classList.add('modal-open');
        
        // Handle close events
        modal.querySelectorAll('[data-dismiss="modal"]').forEach(btn => {
            btn.addEventListener('click', function() {
                modal.remove();
                backdrop.remove();
                document.body.classList.remove('modal-open');
            });
        });
        
        // Handle confirm
        modal.querySelector('[data-confirm="true"]').addEventListener('click', function() {
            modal.remove();
            backdrop.remove();
            document.body.classList.remove('modal-open');
            if (callback) callback();
        });
    }

    // Seed All
    document.getElementById('seedAllBtn').addEventListener('click', function() {
        showCustomConfirm('Bạn có chắc chắn muốn tạo dữ liệu mẫu cho TẤT CẢ các bảng không?', function() {

            loadingModal.show();
            const btn = document.getElementById('seedAllBtn');
            btn.disabled = true;

            fetch('{{ route("admin.seed-data.seed-all") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
            .then(data => {
                loadingModal.hide();
                btn.disabled = false;
                if (data.success) {
                    showCustomAlert('success', '✅ ' + data.message, function() {
                        location.reload();
                    });
                } else {
                    showCustomAlert('error', '❌ ' + data.message);
                }
            })
            .catch(error => {
                loadingModal.hide();
                btn.disabled = false;
                console.error('Error:', error);
                showCustomAlert('error', '❌ Đã xảy ra lỗi: ' + error.message);
            });
        });
    });

    // Custom Alert Dialog
    function showCustomAlert(type, message, callback) {
        const modal = document.createElement('div');
        modal.className = 'modal fade show';
        modal.style.display = 'block';
        modal.style.zIndex = '1055';
        
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        backdrop.style.zIndex = '1050';
        document.body.appendChild(backdrop);
        
        const alertClass = type === 'success' ? 'custom-alert-success' : 'custom-alert-error';
        const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';
        modal.innerHTML = `
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${type === 'success' ? 'Thành công' : 'Lỗi'}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="${alertClass}">
                            <div class="alert-icon"><i class="bi ${icon}"></i></div>
                            <div class="alert-content">
                                <p>${message}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        document.body.classList.add('modal-open');
        
        // Handle close events
        const closeHandler = function() {
            modal.remove();
            backdrop.remove();
            document.body.classList.remove('modal-open');
            if (callback) callback();
        };
        
        modal.querySelectorAll('[data-dismiss="modal"]').forEach(btn => {
            btn.addEventListener('click', closeHandler);
        });
    }

    // Seed Specific
    document.querySelectorAll('.seed-specific-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            const typeName = this.closest('.card').querySelector('.card-header h6').textContent.trim().replace(/\s*Dữ liệu mẫu\s*/g, '');
            
            showCustomConfirm(`Bạn có chắc chắn muốn tạo dữ liệu mẫu cho "${typeName}" không?`, function() {

                loadingModal.show();
                const btn = document.querySelector(`[data-type="${type}"]`);
                btn.disabled = true;

                fetch('{{ route("admin.seed-data.seed-specific") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ type: type })
            })
            .then(response => response.json())
                .then(data => {
                    loadingModal.hide();
                    btn.disabled = false;
                    if (data.success) {
                        showCustomAlert('success', '✅ ' + data.message, function() {
                            location.reload();
                        });
                    } else {
                        showCustomAlert('error', '❌ ' + data.message);
                    }
                })
                .catch(error => {
                    loadingModal.hide();
                    btn.disabled = false;
                    console.error('Error:', error);
                    showCustomAlert('error', '❌ Đã xảy ra lỗi: ' + error.message);
                });
            });
        });
    });
});
</script>

<style>
.page-header {
    padding: 15px 0;
    border-bottom: 2px solid #e9ecef;
    margin-bottom: 20px;
}

.page-header h2 {
    margin: 0;
    color: #2c3e50;
    font-size: 24px;
}

.card {
    border: 1px solid #dee2e6;
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.card-header {
    font-weight: 600;
    padding: 12px 15px;
}

.card-body {
    padding: 15px;
}

.btn-lg {
    padding: 12px 24px;
    font-size: 16px;
}

.seed-specific-btn {
    width: 100%;
    margin-top: 10px;
}

.list-unstyled li {
    padding: 5px 0;
}
</style>
@endsection

