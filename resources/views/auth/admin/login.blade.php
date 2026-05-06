@extends('layouts.app')

@section('title', 'Login Admin - SVC Team')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4><strong>Login Admin</strong></h4>
                </div>
                <div class="card-body p-4">

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Username Admin</label>
                            <input type="text" 
                                   name="adm_username" 
                                   class="form-control @error('adm_username') is-invalid @enderror" 
                                   value="{{ old('adm_username') }}" 
                                   required autofocus>
                            @error('adm_username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Password</label>
                            <input type="password" 
                                   name="adm_password" 
                                   class="form-control @error('adm_password') is-invalid @enderror" 
                                   required>
                            @error('adm_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection