<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Donasi;
use Validator;

class DonasiController extends Controller
{
    public function donasi(Request $request)
    {
        $data = Donasi::orderBy('created_at', 'desc')
        ->paginate(10);
        
        return response()->json([
            'status' => true,
            'message'   => 'List Donasi, limit 10 data',
            'data'  => $data->items(),
            'current_page' => $data->currentPage(),
            'first_page_url' => $data->url(1),
            'from' => $data->firstItem(),
            'last_page' => $data->lastPage(),

            'last_page_url' => $data->url($data->lastPage()) ,
            'next_page_url' => $data->nextPageUrl(),
            'path'  => $data->path(),
            'per_page' => $data->perPage(),
            'prev_page_url' => $data->previousPageUrl(),
            'to' => $data->count(),
            'total' => $data->total()
        ]);
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'donasi_id' => 'required|numeric',
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $data = Donasi::where('id', $request->donasi_id)->get();
        if($data == '') {
            return response()->json([
                'status' => false,
                'message' => 'id donasi tidak ditemukan'
            ]);
        }

        return response()->json([
            'status' => true,
            'message'   => 'Detail Donasi',
            'data'  => $data
        ]);
    }
}
