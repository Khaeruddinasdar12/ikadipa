<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Wirausaha;
use DataTables;

class WirausahaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index() //halaman wirausaha
    {
        return view('admin.wirausaha.index');
    }

    public function tableWirausaha() // api table wirausaha untuk datatable
    {
        $data = Wirausaha::with('user:id,name')
        ->with('alamat', 'alamat.provinsi')
        ->with('kategori:id,nama')
        // ->orderBy('creat', 'asc')
        ->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a href='manage-alumni/show/".$data->user_id."' class='btn btn-secondary btn-xs' title='Lihat Profile'>
            <i class='fa fa-user'></i> Profile Pemilik
            </a>";
        })
        ->editColumn('alamat', function($data) {
            return $data->alamat->tipe." ".$data->alamat->nama_kota.", ".$data->alamat->provinsi->nama_provinsi.". ".$data->lokasi;
        })
        ->addIndexColumn() 
        ->make(true);
    }
}
