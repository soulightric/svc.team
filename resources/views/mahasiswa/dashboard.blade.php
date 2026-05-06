@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4>Selamat Datang, {{ Auth::guard('mahasiswa')->user()->nama }} 👋</h4>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="card border-success">
                                <div class="card-body">
                                    <h5>Total Pengaduan</h5>
                                    <h2 class="text-success">0</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <h5>Diproses</h5>
                                    <h2 class="text-warning">0</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-info">
                                <div class="card-body">
                                    <h5>Selesai</h5>
                                    <h2 class="text-info">0</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('mahasiswa.feedback.create') }}" class="btn btn-success btn-lg">
                            <i class="bi bi-plus-circle"></i> Buat Pengaduan Baru
                        </a>
                    </div>
                    {{-- <div class="mt-4 text-center">
                        <a href="#" class="btn btn-success btn-lg disabled">
                            <i class="bi bi-plus-circle"></i> Buat Pengaduan Baru (Coming Soon)
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection