<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Promo;
class PromoController extends Controller
{
    public function index()
    {
        $data = Promo::select('id','nama','url','gambar')->get();
        return response()->json([
            'status'    => true,
            'message'   => 'Data promo',
            'data'      => $data
        ]);
    }
}
