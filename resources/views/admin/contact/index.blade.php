@extends('admin.layouts.dashboard')

@section('title', 'Liên hệ')

@section('content')
<div class="dashboard-content">
    <div class="page-header">
        <h2 class="page-title">Quản lý Liên hệ</h2>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h3>Thông tin Liên hệ</h3>
        </div>
        <div class="card-body">
            <div class="contact-info">
                <div class="info-item">
                    <i class="bi bi-envelope-fill"></i>
                    <div>
                        <strong>Email:</strong>
                        <span>support@vietlance.com</span>
                    </div>
                </div>
                <div class="info-item">
                    <i class="bi bi-telephone-fill"></i>
                    <div>
                        <strong>Điện thoại:</strong>
                        <span>+84 123 456 789</span>
                    </div>
                </div>
                <div class="info-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <div>
                        <strong>Địa chỉ:</strong>
                        <span>Hà Nội, Việt Nam</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .page-header {
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 600;
        color: #333;
    }

    .content-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .card-header {
        background: #f8f9fa;
        padding: 20px;
        border-bottom: 1px solid #dee2e6;
    }

    .card-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }

    .card-body {
        padding: 30px;
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .info-item i {
        font-size: 24px;
        color: #1a237e;
    }

    .info-item strong {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    .info-item span {
        color: #666;
    }
</style>
@endpush
@endsection

