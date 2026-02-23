@extends('layouts.app')
@section('title', 'Login - Inventory System')
@section('content')
<div class="row justify-content-center" style="min-height: 80vh; align-items: center;">
    <div class="col-md-4">
        <div class="card p-4">
            <div class="card-body">
                <div class="text-center mb-4">
                    <div style="width:64px;height:64px;border-radius:16px;background:linear-gradient(135deg,#4f46e5,#818cf8);display:inline-flex;align-items:center;justify-content:center;margin-bottom:16px;">
                        <i class="fas fa-warehouse fa-lg text-white"></i>
                    </div>
                    <h3 class="fw-bold mb-1">Welcome Back</h3>
                    <p class="text-muted">Sign in to Inventory System</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="test@example.com" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-2" style="padding:12px;">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                </form>
                <div class="mt-4 p-3 rounded-3" style="background: #f8fafc;">
                    <p class="mb-1 fw-semibold" style="font-size:0.85rem;">
                        <i class="fas fa-info-circle me-1" style="color:var(--primary)"></i>Demo Credentials:
                    </p>
                    <p class="mb-0 text-muted" style="font-size:0.85rem;">
                        Email: <code>test@example.com</code> | Password: <code>12345678</code>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
