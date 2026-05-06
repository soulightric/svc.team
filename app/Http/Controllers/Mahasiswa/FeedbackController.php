<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\KategoriLayanan;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{   
    public function create()
    {
        $kategoris = KategoriLayanan::all();
        return view('mahasiswa.feedback.create', compact('kategoris'));
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_layanan'      => 'required|exists:kategori_layanan,id_layanan',
            'judul_feedback'  => 'required|string|max:50',
            'isi_feedback'    => 'required|string',
            'rating'          => 'required|in:1,2,3,4,5',
            'lampiran.*'      => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        // Generate ID Feedback
        $last = Feedback::latest('id_feedback')->first();
        $next = $last ? intval(substr($last->id_feedback, 2)) + 1 : 1;
        $id_feedback = 'FD' . str_pad($next, 4, '0', STR_PAD_LEFT);

        $feedback = Feedback::create([
            'id_feedback'     => $id_feedback,
            'id_layanan'      => $request->id_layanan,
            'id_mahasiswa'    => Auth::guard('mahasiswa')->id(),
            'judul_feedback'  => $request->judul_feedback,
            'isi_feedback'    => $request->isi_feedback,
            'rating'          => $request->rating,
            'status'          => 0,
        ]);

        // Upload Lampiran
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                if ($file->isValid()) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('uploads/lampiran', $filename, 'public');

                    // Generate ID Lampiran
                    $lastLamp = \App\Models\Lampiran::latest('id_lampiran')->first();
                    $nextLamp = $lastLamp ? intval(substr($lastLamp->id_lampiran, 3)) + 1 : 1;
                    $id_lampiran = 'LMP' . str_pad($nextLamp, 3, '0', STR_PAD_LEFT);

                    \App\Models\Lampiran::create([
                        'id_lampiran' => $id_lampiran,
                        'id_feedback' => $id_feedback,
                        'nama_file'   => $file->getClientOriginalName(),
                        'ukuran_file' => $file->getSize(),
                        'tipe_file'   => $file->getMimeType(),
                        'path_file'   => '/storage/' . $path,
                    ]);
                }
            }
        }

        return redirect()->route('mahasiswa.dashboard')
                        ->with('success', 'Pengaduan berhasil dikirim! ID: ' . $id_feedback);
    }
}