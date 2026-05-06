<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Mahasiswa extends Authenticatable
{
    use Notifiable;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_mahasiswa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_mahasiswa',
        'nama',
        'nim',
        'email',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'id_mahasiswa');
    }

    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class, 'id_mahasiswa');
    }
}