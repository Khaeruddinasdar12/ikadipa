<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use DataTables;
class ManageAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index() //halaman manage admin
    {
        return view('admin.manage-admin.index');
    }
    public function store(Request $request)
    {
        $validasi = $this->validate($request, [
            'name'     => 'required|string|max:200',
            'email'       => 'required|email|unique:admins',
            'password'    => 'string|confirmed',
        ]);

        $todb = new Admin;

        $todb->name = $request->name;
        $todb->email = $request->email;
        $todb->password  = bcrypt($request->password);
        $todb->save();

        return $arrayName = array(
            'status' => 'success' , 
            'pesan' => 'Berhasil Menambah Admin' 
        );
    }
    public function update(Request $request, $id)
    {
        $validasi = $this->validate($request, [
            'judul'     => 'required|string|max:200',
            'isi'       => 'required|string',
            'gambar'    => 'image|mimes:jpeg,png,jpg|max:3072',
        ]);

        $data = Donasi::findOrFail($id);

        $data->nama     = $request->judul;
        $data->deskripsi= $request->isi;
        $data->date_end  = $request->date_end;

        $gambar = $request->file('gambar');
        if ($gambar) {
            if ($data->gambar && file_exists(storage_path('app/public/' . $data->gambar))) {
                \Storage::delete('public/' . $data->gambar);
            }
            $gambar_path = $gambar->store('gambar', 'public');
            $data->gambar = $gambar_path;
        }

        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->save();

        return redirect()->back()->with('success', $data->id);
    }
    public function tableAdmin() // api table donasis untuk datatable
    {
        $data = Admin::select('id','name','email')->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a href='' class='btn btn-info btn-xs' 
            title='detail donasi'
            data-toggle='modal' 
            data-target='#modal-detail-donasi'
            data-nama='".$data->nama."'
            data-email='".$data->email."'
            >
            <i class='fa fa-eye'></i>
            </a>

            <a href='donasi/edit/".$data->id."' title='edit donasi' class='btn btn-success btn-xs'>
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
