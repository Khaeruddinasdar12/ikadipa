<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public function jurusan()
    {
        return $this->belongsTo('App\Jurusan', 'jurusan_id');
    }

    public function kategori() // perusahaan
    {
        return $this->belongsTo('App\KategoriPerusahaan', 'kategori_id');
    }

    public function alamat_pribadi()
    {
        return $this->belongsTo('App\Kota', 'alamat_id');
    }

    public function wirausaha()
    {
        return $this->hasOne('App\Wirausaha', 'user_id');
    }

    public function alamat_perusahaans()
    {
        return $this->belongsTo('App\Kota', 'alamat_perusahaan_id');
    }

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
