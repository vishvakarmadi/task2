@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-dark text-white text-center">
                <h5 class="mb-0">Inventory System Login</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Login</button>
                </form>
                <hr>
                <div class="text-muted small">
                    <strong>Demo:</strong> test@example.com / 12345678
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
