<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wirausaha extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function kategori()
    {
        return $this->belongsTo('App\KategoriPerusahaan', 'kategori_id');
    }

    public function alamat()
    {
        return $this->belongsTo('App\Kota', 'alamat_id');
    }
}
