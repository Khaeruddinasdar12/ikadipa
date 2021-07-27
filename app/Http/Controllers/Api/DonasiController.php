<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Donasi;

class DonasiController extends Controller
{
    public function donasi(Request $request)
    {
        $data = Donasi::orderBy('created_at', 'desc')
        ->paginate(10);

        return response()->json([
            'status'    => true,
            'message'   => 'List Donasi, limit 10 data',
            'data'      => $data,
        ]);
    }
}
