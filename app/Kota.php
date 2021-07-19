<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    public function provinsi()
    {
        return $this->belongsTo('App\Provinsi', 'provinsi_id');
    }
}
