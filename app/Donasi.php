<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    public function getDateEndAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['date_end'])
        // ->diffForHumans();
        ->translatedFormat('d F Y');
    }

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
        ->diffForHumans();
    }
}
