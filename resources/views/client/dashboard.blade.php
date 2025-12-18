@extends('client.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-speedometer2 me-2"></i>Client Dashboard
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Chào mừng, <strong>{{ Auth::guard('client')->user()->name }}</strong>!
                    </div>
                    <p>Bạn đã đăng nhập thành công vào hệ thống client.</p>
                    
                    @if(Auth::guard('client')->user()->company_name)
                        <div class="alert alert-info">
                            <i class="bi bi-building me-2"></i>
                            Công ty: <strong>{{ Auth::guard('client')->user()->company_name }}</strong>
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        <form method="POST" action="{{ route('client.logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

