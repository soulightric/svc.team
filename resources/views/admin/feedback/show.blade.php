@extends('layouts.app')

@section('title', 'Detail Pengaduan - {{ $feedback->id_feedback }}')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4>Detail Pengaduan - <strong>{{ $feedback->id_feedback }}</strong></h4>
            <a href="{{ route('admin.feedback.index') }}" class="btn btn-sm btn-outline-light">← Kembali</a>
        </div>
        
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Mahasiswa:</strong> {{ $feedback->mahasiswa->nama }}</p>
                    <p><strong>NIM:</strong> {{ $feedback->mahasiswa->nim }}</p>
                    <p><strong>Kategori:</strong> {{ $feedback->kategori->nama_kategori ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Rating:</strong> {{ str_repeat('⭐', $feedback->rating) }}</p>
                    <p><strong>Tanggal:</strong> {{ $feedback->created_at->format('d F Y H:i') }}</p>
                    <p><strong>Status Saat Ini:</strong> 
                        @switch($feedback->status)
                            @case(0)
                                <span class="badge bg-warning">Menunggu</span>
                                @break
                            @case(1)
                                <span class="badge bg-info">Diproses</span>
                                @break
                            @case(2)
                                <span class="badge bg-success">Selesai</span>
                                @break
                            @case(3)
                                <span class="badge bg-danger">Ditolak</span>
                                @break
                        @endswitch
                    </p>
                </div>
            </div>

            <h5 class="mb-2">Judul Pengaduan</h5>
            <p class="fs-5 fw-bold">{{ $feedback->judul_feedback }}</p>

            <h5 class="mb-2">Isi Pengaduan</h5>
            <p style="white-space: pre-wrap; background:#f8f9fa; padding:15px; border-radius:8px;">
                {{ $feedback->isi_feedback }}
            </p>

            <!-- Lampiran -->
            @if($feedback->lampirans->isNotEmpty())
            <h5 class="mt-4">Lampiran File</h5>
            <div class="row">
                @foreach($feedback->lampirans as $lamp)
                <div class="col-md-6 mb-2">
                    <a href="{{ asset($lamp->path_file) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                        📎 {{ $lamp->nama_file }}
                    </a>
                </div>
                @endforeach
            </div>
            @endif

            <hr>

            <!-- Riwayat Tanggapan -->
            <h5>Tanggapan Admin</h5>
            @if($feedback->tanggapans->isEmpty())
                <p class="text-muted">Belum ada tanggapan dari admin.</p>
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

            <!-- Form Balas + Ubah Status -->
            <form method="POST" action="{{ route('admin.feedback.tanggapan.store', $feedback->id_feedback) }}">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Tanggapan / Solusi</label>
                        <textarea name="isi_tanggapan" class="form-control" rows="4" required 
                                placeholder="Tulis tanggapan Anda..."></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Ubah Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $feedback->status == 1 ? 'selected' : '' }}>Diproses</option>
                            <option value="2">Selesai</option>
                            <option value="3">Ditolak</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-3">
                    <i class="bi bi-send"></i> Kirim Tanggapan & Update Status
                </button>
            </form>
        </div>
    </div>
</div>
@endsection