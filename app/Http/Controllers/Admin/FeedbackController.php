<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Tanggapan;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with(['mahasiswa', 'kategori'])->latest()->paginate(15);
        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function show($id_feedback)
    {
        $feedback = Feedback::with(['mahasiswa', 'kategori', 'lampirans', 'tanggapans.admin'])
                            ->findOrFail($id_feedback);
        
        return view('admin.feedback.show', compact('feedback'));
    }

    public function storeTanggapan(Request $request, $id_feedback)
    {
        $request->validate([
            'isi_tanggapan' => 'required|string',
            'status' => 'nullable|in:1,2,3'  // 1=Diproses, 2=Selesai, 3=Ditolak
        ]);

        $feedback = Feedback::findOrFail($id_feedback);

        // Generate ID Tanggapan
        $last = Tanggapan::latest('id_tanggapan')->first();
        $next = $last ? intval(substr($last->id_tanggapan, 3)) + 1 : 1;
        $id_tanggapan = 'TGP' . str_pad($next, 3, '0', STR_PAD_LEFT);

        Tanggapan::create([
            'id_tanggapan' => $id_tanggapan,
            'id_admin'     => Auth::guard('admin')->id(),
            'id_feedback'  => $id_feedback,
            'isi_tanggapan'=> $request->isi_tanggapan,
        ]);

        // Update status jika dipilih
        if ($request->has('status')) {
            $feedback->update(['status' => $request->status]);
        } else {
            $feedback->update(['status' => 1]); // default ke Diproses
        }

        return redirect()->back()->with('success', 'Tanggapan berhasil dikirim dan status diupdate.');
    }
}