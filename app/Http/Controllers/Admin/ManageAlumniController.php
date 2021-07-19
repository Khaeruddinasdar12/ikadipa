<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use DataTables;
use DB;
use App\Wirausaha;
class ManageAlumniController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function test()
    {
        $data = User::find(1)->wirausaha;
        return $data;    
    }

    public function alumni() //halaman manage alumni (alumni)
    {
        return view('admin.manage-alumni.alumni');
    }

    public function mendaftar() //halaman manage alumni (alumni)
    {
        return view('admin.manage-alumni.mendaftar');
    }

    public function ditolak() //halaman manage alumni (ditolak)
    {
        return view('admin.manage-alumni.ditolak');
    }

    public function tolak(Request $request, $id) //post tolak alumni
    {
        $validasi = $this->validate($request, [
            'pesan'     => 'required|string',
        ]);

        $data = User::findOrFail($id);
        $data->is_active = 'tolak';
        $data->komentar = $request->pesan;
        $data->save();

        return redirect()->back()->with('success', 'Data ini telah ditolak');
    }

    public function konfirmasi(Request $request, $id) //konfirmasi sebagai alumni
    {
        $data = User::find($id);
        if($data == '') {
            return $arrayName = array(
                'status' => 'error',
                'pesan' => 'Id alumni tidak ditemukan'
            );
        }
        $data->is_active = '1';
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Data ini dikonfirmasi sebagai alumni'
        );    
    }

    public function show($id) //halaman detail alumni
    {
        // return 'ahha';
        $data = User::with('jurusan')
        ->with('alamat_pribadi', 'alamat_pribadi.provinsi')
        ->with('alamat_perusahaans', 'alamat_perusahaans.provinsi')
        ->with('kategori')
        ->findOrFail($id);

        $wirausaha = Wirausaha::where('user_id', $id)
        ->with('kategori')
        ->with('alamat')
        ->get();

        // return $data;
        return view('admin.manage-alumni.show', [
            'data'=> $data,
            'wirausaha' => $wirausaha
        ]);
    }

    public function tableAlumni() // api table users (alumni) untuk datatable
    {
        $data = User::where('is_active', '1')
        ->with('jurusan:id,nama')
        ->orderBy('created_at', 'desc')
        ->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a href='show/".$data->id."' class='btn btn-info btn-xs' 
            title='detail alumni'
            >
            <i class='fa fa-eye'></i>
            </a>

            <button class='btn btn-danger btn-xs'
            title='Hapus Donasi' 
            href='donasi/delete-donasi/".$data->id."'
            onclick='hapus_data()'
            id='del_id'
            >
            <i class='fa fa-trash'></i>
            </button>";
        })
        ->addIndexColumn() 
        ->make(true);
    }

    public function tableMendaftar() // api table users (alumni mendaftar) untuk datatable
    {
        $data = User::where('is_active', '0')
        ->orderBy('created_at', 'desc')
        ->with('jurusan:id,nama')
        ->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a href='show/".$data->id."' class='btn btn-info btn-xs' 
            title='detail alumni'
            >
            <i class='fa fa-eye'></i>
            </a>

            <button class='btn btn-danger btn-xs'
            title='Hapus Donasi' 
            href='donasi/delete-donasi/".$data->id."'
            onclick='hapus_data()'
            id='del_id'
            >
            <i class='fa fa-trash'></i>
            </button>";
        })
        ->addIndexColumn() 
        ->make(true);
    }

    public function tableDitolak() // api table users (alumni ditolak) untuk datatable
    {
        $data = User::where('is_active', 'tolak')
        ->with('jurusan:id,nama')
        ->orderBy('created_at', 'desc')
        ->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a href='show/".$data->id."' title='detail alumni' class='btn btn-info btn-xs'>
            <i class='fa fa-edit'></i>
            </a>

            <button class='btn btn-danger btn-xs'
            title='Hapus Donasi' 
            href='donasi/delete-donasi/".$data->id."'
            onclick='hapus_data()'
            id='del_id'
            >
            <i class='fa fa-trash'></i>
            </button>";
        })
        ->addIndexColumn() 
        ->make(true);
    }
}
