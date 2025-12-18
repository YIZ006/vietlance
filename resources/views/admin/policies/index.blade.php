@extends('admin.layouts.dashboard')

@section('title', 'Chính sách')

@section('content')
<div class="dashboard-content">
    <div class="page-header">
        <h2 class="page-title">Quản lý Chính sách</h2>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h3>Chính sách và Điều khoản</h3>
        </div>
        <div class="card-body">
            <div class="policy-section">
                <h4>1. Chính sách Bảo mật</h4>
                <p>Chúng tôi cam kết bảo vệ thông tin cá nhân của người dùng...</p>
            </div>

            <div class="policy-section">
                <h4>2. Điều khoản Sử dụng</h4>
                <p>Bằng việc sử dụng dịch vụ của Vietlance, bạn đồng ý với các điều khoản sau...</p>
            </div>

            <div class="policy-section">
                <h4>3. Chính sách Hoàn tiền</h4>
                <p>Chính sách hoàn tiền được áp dụng trong các trường hợp...</p>
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

    .policy-section {
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #eee;
    }

    .policy-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .policy-section h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1a237e;
        margin-bottom: 10px;
    }

    .policy-section p {
        color: #666;
        line-height: 1.6;
    }
</style>
@endpush
@endsection

