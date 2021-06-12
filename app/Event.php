<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function getDateStartAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['date_start'])
        // ->diffForHumans();
        ->translatedFormat('l, d F Y');
    }

    public function getDateEndAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['date_end'])
        // ->diffForHumans();
        ->translatedFormat('l, d F Y');
    }
}
