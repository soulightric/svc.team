<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_admin',
        'adm_username',
        'adm_password'
    ];

    protected $hidden = [
        'adm_password',
        'remember_token',
    ];

    // Important: Laravel expect 'password' column by default
    public function getAuthPassword()
    {
        return $this->adm_password;
    }

    public function tanggapans()
    {
        return $this->hasMany(Tanggapan::class, 'id_admin');
    }
}