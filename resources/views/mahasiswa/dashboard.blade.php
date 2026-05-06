@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h4>Selamat Datang, {{ Auth::guard('mahasiswa')->user()->nama }} 👋</h4>
                    <a href="{{ route('mahasiswa.feedback.create') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-plus-circle"></i> Pengaduan Baru
                    </a>
                </div>
                
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <h5 class="mb-3">Riwayat Pengaduan Saya</h5>

                    @php
                        $feedbacks = Auth::guard('mahasiswa')->user()->feedbacks()
                                        ->with(['kategori'])
                                        ->latest()
                                        ->get();
                    @endphp

                    @if ($feedbacks->isEmpty())
                        <div class="alert alert-info text-center py-5">
                            <h5>Belum ada pengaduan</h5>
                            <p>Ayo buat pengaduan pertama Anda sekarang</p>
                            <a href="{{ route('mahasiswa.feedback.create') }}" class="btn btn-success mt-3">
                                Buat Pengaduan
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($feedbacks as $feedback)
                                    <tr>
                                        <td><strong>{{ $feedback->id_feedback }}</strong></td>
                                        <td>{{ Str::limit($feedback->judul_feedback, 45) }}</td>
                                        <td>{{ $feedback->kategori->nama_kategori ?? '-' }}</td>
                                        <td>{{ str_repeat('⭐', $feedback->rating) }}</td>
                                        <td>
                                            @if($feedback->status == 0)
                                                <span class="badge bg-warning">Menunggu</span>
                                            @elseif($feedback->status == 1)
                                                <span class="badge bg-info">Diproses</span>
                                            @elseif($feedback->status == 2)
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>{{ $feedback->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('mahasiswa.feedback.show', $feedback->id_feedback) ?? '#' }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection