@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-dark text-white d-flex justify-content-between">
                    <h4>Dashboard Admin - {{ Auth::guard('admin')->user()->adm_username }}</h4>
                    <a href="{{ route('admin.logout') }}" class="btn btn-sm btn-outline-light" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.feedback.index') }}" class="btn btn-primary mb-3">
                        <i class="bi bi-list"></i> Lihat Semua Pengaduan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection