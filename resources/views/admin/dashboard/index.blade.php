@extends('admin.layouts.dashboard')

@section('title', 'Trang quản trị')

@section('content')
<div class="dashboard-content">
    <!-- Admin Info Card -->
    <div class="admin-info-card">
        <div class="info-item">
            <i class="bi bi-person-badge"></i>
            <div>
                <span class="info-label">Admin ID:</span>
                <span class="info-value">{{ Auth::guard('admin')->user()->id }}</span>
            </div>
        </div>
        <div class="info-item">
            <i class="bi bi-person"></i>
            <div>
                <span class="info-label">Tên:</span>
                <span class="info-value">{{ Auth::guard('admin')->user()->name }}</span>
            </div>
        </div>
        <div class="info-item">
            <i class="bi bi-envelope"></i>
            <div>
                <span class="info-label">Email:</span>
                <span class="info-value">{{ Auth::guard('admin')->user()->email }}</span>
            </div>
        </div>
        @if(Auth::guard('admin')->user()->admin_login)
        <div class="info-item">
            <i class="bi bi-at"></i>
            <div>
                <span class="info-label">Admin Login:</span>
                <span class="info-value">{{ Auth::guard('admin')->user()->admin_login }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <label for="timeFilter" class="filter-label">Lọc theo thời gian:</label>
        <select id="timeFilter" class="filter-select">
            <option value="all">Tất cả</option>
            <option value="today">Hôm nay</option>
            <option value="week">Tuần này</option>
            <option value="month">Tháng này</option>
            <option value="year">Năm nay</option>
        </select>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-section">
        <h3 class="section-title">Thống kê</h3>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon stat-icon-blue">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Tổng Talent</div>
                    <div class="stat-value">{{ number_format($stats['total_talents']) }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-green">
                    <i class="bi bi-building"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Tổng Client</div>
                    <div class="stat-value">{{ number_format($stats['total_clients']) }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-orange">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Talent Hoạt động</div>
                    <div class="stat-value">{{ number_format($stats['active_talents']) }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-purple">
                    <i class="bi bi-building-check"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-label">Client Hoạt động</div>
                    <div class="stat-value">{{ number_format($stats['active_clients']) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-section">
        <div class="chart-container">
            <h3 class="section-title">Biểu Đồ Tổng Quan</h3>
            <div class="chart-legend">
                <span class="legend-item"><span class="legend-color" style="background: #4285F4;"></span> Talent</span>
                <span class="legend-item"><span class="legend-color" style="background: #34A853;"></span> Client</span>
                <span class="legend-item"><span class="legend-color" style="background: #EA4335;"></span> Hoạt động</span>
            </div>
            <div class="chart-wrapper">
                <canvas id="overviewChart"></canvas>
            </div>
        </div>

        <div class="chart-container">
            <h3 class="section-title">Biểu Đồ Chi Tiết</h3>
            <div class="chart-legend">
                <span class="legend-item"><span class="legend-color" style="background: #4285F4;"></span> Số Freelance</span>
                <span class="legend-item"><span class="legend-color" style="background: #FBBC05;"></span> Số Client</span>
            </div>
            <div class="chart-wrapper">
                <canvas id="detailChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Overview Chart (Donut)
    const overviewCtx = document.getElementById('overviewChart').getContext('2d');
    const overviewChart = new Chart(overviewCtx, {
        type: 'doughnut',
        data: {
            labels: ['Talent', 'Client', 'Hoạt động'],
            datasets: [{
                data: [
                    {{ $chartData['talents'] }},
                    {{ $chartData['clients'] }},
                    {{ $chartData['active_talents'] + $chartData['active_clients'] }}
                ],
                backgroundColor: ['#4285F4', '#34A853', '#EA4335'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Detail Chart (Bar)
    const detailCtx = document.getElementById('detailChart').getContext('2d');
    const detailChart = new Chart(detailCtx, {
        type: 'bar',
        data: {
            labels: ['Tổng số', 'Đang hoạt động'],
            datasets: [
                {
                    label: 'Số Talent',
                    data: [{{ $chartData['talents'] }}, {{ $chartData['active_talents'] }}],
                    backgroundColor: '#4285F4',
                    yAxisID: 'y'
                },
                {
                    label: 'Số Client',
                    data: [{{ $chartData['clients'] }}, {{ $chartData['active_clients'] }}],
                    backgroundColor: '#FBBC05',
                    yAxisID: 'y'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    position: 'left'
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endpush
@endsection

