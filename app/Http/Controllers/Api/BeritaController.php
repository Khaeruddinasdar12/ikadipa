<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Berita;

class BeritaController extends Controller
{
    public function berita(Request $request)
    {
        $data = Berita::orderBy('created_at', 'desc')
        ->paginate(10);

        return response()->json([
            'status'    => true,
            'message'   => 'List Berita, limit 10 data',
            'data'      => $data,
        ]);
    }
}
