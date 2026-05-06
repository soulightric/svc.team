@extends('layouts.app')

@section('title', 'Buat Pengaduan Baru')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4><i class="bi bi-plus-circle"></i> Buat Pengaduan Baru</h4>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('mahasiswa.feedback.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori Layanan</label>
                            <select name="id_layanan" class="form-select @error('id_layanan') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id_layanan }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                            @error('id_layanan') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Pengaduan</label>
                            <input type="text" name="judul_feedback" class="form-control @error('judul_feedback') is-invalid @enderror" 
                                   maxlength="50" required placeholder="Contoh: Kursi di ruang B rusak">
                            @error('judul_feedback') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Pengaduan</label>
                            <textarea name="isi_feedback" rows="6" class="form-control @error('isi_feedback') is-invalid @enderror" 
                                      required placeholder="Jelaskan secara detail..."></textarea>
                            @error('isi_feedback') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Rating</label>
                            <select name="rating" class="form-select @error('rating') is-invalid @enderror" required>
                                <option value="">-- Beri Rating --</option>
                                <option value="5">⭐⭐⭐⭐⭐ Sangat Baik</option>
                                <option value="4">⭐⭐⭐⭐ Baik</option>
                                <option value="3">⭐⭐⭐ Cukup</option>
                                <option value="2">⭐⭐ Kurang</option>
                                <option value="1">⭐ Sangat Kurang</option>
                            </select>
                            @error('rating') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Lampiran (Opsional)</label>
                            <input type="file" name="lampiran[]" class="form-control @error('lampiran') is-invalid @enderror" multiple>
                            <small class="text-muted">Bisa upload multiple file (max 5MB per file)</small>
                            @error('lampiran') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-send"></i> Kirim Pengaduan
                            </button>
                            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection