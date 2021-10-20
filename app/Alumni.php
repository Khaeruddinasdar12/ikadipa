<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $table = "alumnis";
 
    protected $fillable = ['stb','name','angkatan','jurusan_id'];
    public function jurusan()
    {
        return $this->belongsTo('App\Jurusan', 'jurusan_id');
    }

    
}
