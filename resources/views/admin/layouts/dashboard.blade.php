<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Trang quản trị') - Vietlance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="header-left">
            <div class="logo-section">
                <i class="bi bi-gear-fill"></i>
                <span class="logo-text">Vietlance</span>
            </div>
        </div>
        <div class="header-right">
            @if(Auth::guard('admin')->user()->role === 'superadmin')
                <a href="{{ route('admin.seed-data.index') }}" class="header-link btn-seed-data" title="Tạo dữ liệu mẫu">
                    <i class="bi bi-database-add"></i> Tạo dữ liệu mẫu
                </a>
            @endif
            <span class="welcome-text">Xin chào Admin {{ Auth::guard('admin')->user()->name }} (ID: {{ Auth::guard('admin')->user()->id }})</span>
            <span class="role-badge">Quyền: {{ ucfirst(Auth::guard('admin')->user()->role) }}</span>
            <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="header-link btn-logout">Đăng Xuất</button>
            </form>
        </div>
    </header>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard.secure') }}" 
                   data-route="dashboard" 
                   class="nav-item {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-item" data-route="orders">
                    <i class="bi bi-cart3"></i>
                    <span>Quản lý ...</span>
                </a>
                <a href="{{ route('admin.clients.index') }}" 
                   data-route="clients" 
                   class="nav-item {{ request()->routeIs('admin.clients*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Quản lý Khách hàng</span>
                </a>
                <a href="{{ route('admin.talents.index') }}" 
                   data-route="talents" 
                   class="nav-item {{ request()->routeIs('admin.talents*') ? 'active' : '' }}">
                    <i class="bi bi-person-workspace"></i>
                    <span>Quản lý Talent</span>
                </a>
                <a href="{{ route('admin.programming-languages.index') }}" 
                   data-route="programming-languages" 
                   class="nav-item {{ request()->routeIs('admin.programming-languages*') ? 'active' : '' }}">
                    <i class="bi bi-code-square"></i>
                    <span>Ngôn ngữ Lập trình</span>
                </a>
                <a href="{{ route('admin.accounts.index') }}" 
                   data-route="admins" 
                   class="nav-item {{ request()->routeIs('admin.accounts*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i>
                    <span>Tài khoản Quản trị</span>
                </a>
                <a href="{{ route('admin.job-categories.index') }}" 
                   data-route="job-categories" 
                   class="nav-item {{ request()->routeIs('admin.job-categories*') ? 'active' : '' }}">
                    <i class="bi bi-list-ul"></i>
                    <span>Quản lý Danh mục Công việc</span>
                </a>
                <a href="{{ route('admin.it-jobs.index') }}" 
                   data-route="it-jobs" 
                   class="nav-item {{ request()->routeIs('admin.it-jobs*') ? 'active' : '' }}">
                    <i class="bi bi-briefcase-fill"></i>
                    <span>Quản lý Công việc IT</span>
                </a>
                <a href="{{ route('admin.policies') }}" 
                   data-route="policies" 
                   class="nav-item {{ request()->routeIs('admin.policies') ? 'active' : '' }}">
                    <i class="bi bi-file-text"></i>
                    <span>Chính sách</span>
                </a>
                <a href="{{ route('admin.contact') }}" 
                   data-route="contact" 
                   class="nav-item {{ request()->routeIs('admin.contact') ? 'active' : '' }}">
                    <i class="bi bi-envelope"></i>
                    <span>Liên hệ</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // AJAX Navigation - Load content without page reload
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.sidebar-nav .nav-item[data-route]');
            
            navItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const route = this.getAttribute('data-route');
                    const url = this.getAttribute('href');
                    
                    if (route && url && url !== '#') {
                        loadContent(url, route);
                        
                        // Update active state
                        navItems.forEach(nav => nav.classList.remove('active'));
                        this.classList.add('active');
                    }
                });
            });

            // Set initial active state based on current route
            const currentPath = window.location.pathname;
            navItems.forEach(item => {
                const itemUrl = item.getAttribute('href');
                if (itemUrl && currentPath.includes(itemUrl.split('/').pop())) {
                    item.classList.add('active');
                }
            });
            
            // Initialize pagination links on page load
            initializePaginationLinks();
        });

        function loadContent(url, route) {
            // Show loading indicator
            const mainContent = document.querySelector('.admin-main');
            const originalContent = mainContent.innerHTML;
            mainContent.innerHTML = '<div class="loading-spinner"><i class="bi bi-arrow-repeat"></i> Đang tải...</div>';
            
            // Build URL with AJAX parameter
            const separator = url.includes('?') ? '&' : '?';
            const ajaxUrl = url + separator + 'ajax=1';
            
            // Fetch content via AJAX
            fetch(ajaxUrl, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json, text/html',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                // Check if response is ok
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const contentType = response.headers.get('content-type') || '';
                
                // Try to parse as JSON first
                if (contentType.includes('application/json')) {
                    return response.json().then(data => ({ type: 'json', data }));
                }
                
                // Otherwise parse as text/HTML
                return response.text().then(data => ({ type: 'html', data }));
            })
            .then(result => {
                if (result.type === 'json' && result.data.html) {
                    // JSON response with HTML
                    mainContent.innerHTML = result.data.html;
                    // Update page title
                    if (result.data.title) {
                        document.title = result.data.title + ' - Vietlance';
                    }
                    // Execute scripts in the loaded content
                    executeScripts(mainContent);
                    // Reinitialize charts if needed
                    initializeCharts();
                } else if (result.type === 'html') {
                    // HTML response - extract main content
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(result.data, 'text/html');
                    const content = doc.querySelector('.dashboard-content') || doc.querySelector('.admin-main') || doc.body;
                    
                    if (content) {
                        mainContent.innerHTML = content.innerHTML;
                        // Execute scripts
                        executeScripts(mainContent);
                        initializeCharts();
                    } else {
                        throw new Error('Không tìm thấy nội dung trong phản hồi');
                    }
                } else {
                    throw new Error('Định dạng phản hồi không hợp lệ');
                }
                
                // Update URL without reload
                window.history.pushState({route: route, url: url}, '', url);
                
                // Reinitialize pagination links after content loads
                initializePaginationLinks();
            })
            .catch(error => {
                console.error('Error loading content:', error);
                mainContent.innerHTML = `
                    <div class="custom-alert custom-alert-error">
                        <div class="alert-icon">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div class="alert-content">
                            <strong>Lỗi khi tải nội dung</strong>
                            <p>${error.message || 'Vui lòng thử lại sau.'}</p>
                            <button onclick="location.reload()" class="btn-retry">
                                <i class="bi bi-arrow-clockwise"></i> Tải lại trang
                            </button>
                        </div>
                    </div>
                `;
            });
        }

        // Execute scripts in loaded content
        function executeScripts(container) {
            const scripts = container.querySelectorAll('script');
            scripts.forEach(oldScript => {
                const newScript = document.createElement('script');
                Array.from(oldScript.attributes).forEach(attr => {
                    newScript.setAttribute(attr.name, attr.value);
                });
                if (oldScript.src) {
                    newScript.src = oldScript.src;
                    newScript.onload = () => {
                        // Script loaded, trigger bulk actions update if exists
                        if (typeof updateBulkActions === 'function') {
                            setTimeout(updateBulkActions, 100);
                        }
                    };
                } else {
                    newScript.textContent = oldScript.textContent;
                    // Execute immediately for inline scripts
                    setTimeout(() => {
                        if (typeof updateBulkActions === 'function') {
                            updateBulkActions();
                        }
                    }, 100);
                }
                oldScript.parentNode.replaceChild(newScript, oldScript);
            });
        }

        // Initialize pagination links to work with AJAX
        function initializePaginationLinks() {
            const paginationLinks = document.querySelectorAll('.pagination a');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');
                    if (url && url !== '#') {
                        // Extract route from current page
                        const currentRoute = document.querySelector('.nav-item.active')?.getAttribute('data-route') || 'dashboard';
                        loadContent(url, currentRoute);
                    }
                });
            });
        }

        function initializeCharts() {
            // Reinitialize Chart.js if charts exist
            if (typeof Chart !== 'undefined') {
                const overviewCtx = document.getElementById('overviewChart');
                const detailCtx = document.getElementById('detailChart');
                
                if (overviewCtx) {
                    // Chart will be initialized by the view's script
                    const scripts = document.querySelectorAll('.admin-main script');
                    scripts.forEach(script => {
                        if (script.src) {
                            const newScript = document.createElement('script');
                            newScript.src = script.src;
                            document.body.appendChild(newScript);
                        } else {
                            eval(script.innerHTML);
                        }
                    });
                }
            }
        }

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function(e) {
            if (e.state && e.state.url) {
                const url = e.state.url;
                const route = e.state.route || 'dashboard';
                loadContent(url, route);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

