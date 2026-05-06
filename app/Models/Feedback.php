<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';
    protected $primaryKey = 'id_feedback';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_feedback', 'id_layanan', 'id_mahasiswa',
        'judul_feedback', 'isi_feedback', 'rating', 'status'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriLayanan::class, 'id_layanan', 'id_layanan');
    }

    public function lampirans()
    {
        return $this->hasMany(Lampiran::class, 'id_feedback');
    }

    public function tanggapans()
    {
        return $this->hasMany(Tanggapan::class, 'id_feedback');
    }
}