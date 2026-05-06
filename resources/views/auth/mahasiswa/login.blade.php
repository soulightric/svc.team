@extends('layouts.app')

@section('title', 'Login Mahasiswa')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Login Mahasiswa</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('mahasiswa.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Username / NIM</label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                                   value="{{ old('username') }}" required autofocus>
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                    <div class="text-center mt-3">
                        Belum punya akun? 
                        <a href="{{ route('mahasiswa.register') }}">Daftar di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection