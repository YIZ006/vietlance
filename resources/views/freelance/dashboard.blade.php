@extends('freelance.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-speedometer2 me-2"></i>Freelance Dashboard
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Chào mừng, <strong>{{ Auth::guard('freelance')->user()->name }}</strong>!
                    </div>
                    <p>Bạn đã đăng nhập thành công vào hệ thống freelance.</p>
                    
                    @if(Auth::guard('freelance')->user()->github_id)
                        <div class="alert alert-info">
                            <i class="bi bi-github me-2"></i>
                            Đã liên kết với GitHub
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        <form method="POST" action="{{ route('freelance.logout') }}">
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

