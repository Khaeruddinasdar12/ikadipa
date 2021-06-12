<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
        // ->diffForHumans();
        ->translatedFormat('l, d F Y H:i');
    }

    public function admin()
    {
        return $this->belongsTo('App\Admin', 'admin_id');
    }

}
