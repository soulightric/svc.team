@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-success text-white d-flex justify-content-between">
            <h4>Detail Pengaduan - <strong>{{ $feedback->id_feedback }}</strong></h4>
            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-sm btn-outline-light">← Kembali ke Dashboard</a>
        </div>
        
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Kategori:</strong> {{ $feedback->kategori->nama_kategori ?? '-' }}</p>
                    <p><strong>Rating:</strong> {{ str_repeat('⭐', $feedback->rating) }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal:</strong> {{ $feedback->created_at->format('d F Y H:i') }}</p>
                    <p><strong>Status:</strong> 
                        @if($feedback->status == 0)
                            <span class="badge bg-warning">Menunggu</span>
                        @elseif($feedback->status == 1)
                            <span class="badge bg-info">Diproses</span>
                        @elseif($feedback->status == 2)
                            <span class="badge bg-success">Selesai</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </p>
                </div>
            </div>

            <h5>Judul:</h5>
            <p class="fs-5 fw-bold">{{ $feedback->judul_feedback }}</p>

            <h5>Isi Pengaduan:</h5>
            <p style="white-space: pre-wrap; background:#f8f9fa; padding:15px; border-radius:8px;">
                {{ $feedback->isi_feedback }}
            </p>

            <!-- Lampiran -->
            @if($feedback->lampirans->isNotEmpty())
            <h5 class="mt-4">Lampiran:</h5>
            @foreach($feedback->lampirans as $lampiran)
                <a href="{{ asset($lampiran->path_file) }}" target="_blank" class="btn btn-outline-secondary btn-sm mb-2">
                    📎 {{ $lampiran->nama_file }}
                </a><br>
            @endforeach
            @endif

            <hr>

            <!-- Tanggapan dari Admin -->
            <h5>Tanggapan Admin</h5>
            @if($feedback->tanggapans->isEmpty())
                <div class="alert alert-info">
                    Belum ada tanggapan dari admin. Mohon tunggu.
                </div>
            @else
                @foreach($feedback->tanggapans as $tanggapan)
                <div class="alert alert-secondary">
                    <small class="text-muted">
                        {{ $tanggapan->created_at->format('d M Y H:i') }} — 
                        <strong>{{ $tanggapan->admin->adm_username ?? 'Admin' }}</strong>
                    </small>
                    <p class="mb-0 mt-2">{{ $tanggapan->isi_tanggapan }}</p>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection