<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Berita;
use DB;
class BeritaController extends Controller
{
    public function berita(Request $request)
    {
        $data = Berita::select('beritas.id', 'beritas.judul', 'beritas.gambar', 'beritas.created_at', DB::raw('group_concat(concat(kategori_beritas.nama)SEPARATOR ", ") as kategori'))
        ->leftjoin("kategori_beritas",\DB::raw("FIND_IN_SET(kategori_beritas.id,beritas.kategori)"),">",\DB::raw("'0'"))
        ->groupBy('beritas.id')
        ->paginate(8);

        return response()->json([
            'status' => true,
            'message'   => 'List Berita, limit 10 data',
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
}
