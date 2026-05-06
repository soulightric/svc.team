@extends('layouts.app')

@section('title', 'Daftar Pengaduan - Admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4><i class="bi bi-list-ul"></i> Semua Pengaduan Mahasiswa</h4>
        </div>
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Mahasiswa</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feedbacks as $feedback)
                        <tr>
                            <td><strong>{{ $feedback->id_feedback }}</strong></td>
                            <td>{{ $feedback->mahasiswa->nama ?? '-' }}</td>
                            <td>{{ $feedback->judul_feedback }}</td>
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
                            <td>{{ $feedback->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.feedback.show', $feedback->id_feedback) }}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Belum ada pengaduan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $feedbacks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection