<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\KategoriBerita;
use DataTables;
use App\Berita;
use Auth;
use DB;
use App\Fcmtoken;
class BeritaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index() //halaman list berita
    {
        return view('admin.berita.index');
    }

    public function create() //halaman create berita
    {
        $ktg = KategoriBerita::select('id', 'nama')->get();
        return view('admin.berita.create', ['ktg' => $ktg]);
    }

    public function edit($id) //halaman edit berita
    {
        // $ktg = Berita::select('id', 'judul')->where('kategori', 'like', "%\"{$ktgr}\"%")->get();
        $ktg = KategoriBerita::select('id', 'nama')->get();
        $data = Berita::findOrFail($id);

        return view('admin.berita.edit', [
            'data'  => $data,
            'ktg'   => $ktg
        ]);
    }   

    public function show($id) //halaman preview/detail berita
    {
        $data = 
        Berita::select('beritas.id', 'beritas.judul', 'beritas.created_at', 'beritas.gambar', 'beritas.isi', 'admins.name as admin', DB::raw('group_concat(concat(kategori_beritas.nama)SEPARATOR ", ") as kategori'))
        ->leftjoin("kategori_beritas",\DB::raw("FIND_IN_SET(kategori_beritas.id,beritas.kategori)"),">",\DB::raw("'0'"))
        ->join('admins', 'beritas.admin_id', '=', 'admins.id')
        ->where('beritas.id', $id)
        ->first();

        // return $data;
        return view('admin.berita.show', [
            'data'  => $data
        ]);
    } 

    public function store(Request $request)
    {
        $validasi = $this->validate($request, [
            'judul'     => 'required|string|max:200',
            'isi'       => 'required|string',
            'gambar'    => 'image|mimes:jpeg,png,jpg|max:3072',
            'kategori'  => 'required'
        ]);

        $todb = new Berita;

        $todb->judul     = $request->judul;
        $todb->isi       = $request->isi;
        $input = "";
        foreach($request->kategori as $ktg)   {  
            $input .= $ktg.",";  
        } 
        $todb->kategori  = $input;

        $gambar = $request->file('gambar');
        if ($gambar) {
            $gambar_path = $gambar->store('gambar', 'public');
            $todb->gambar = $gambar_path;
        }

        $todb->admin_id = Auth::guard('admin')->user()->id;
        $todb->save();

        $firebaseToken = Fcmtoken::pluck('token')->all();
        $fcm_key = config('app.fcm_key');
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => "Berita! ".$request->judul,
                "body" => "Lihat segera di aplikasi",  
            ]
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=' . $fcm_key,
            'Content-Type: application/json',
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
               
        $response = curl_exec($ch);

        return redirect()->back()->with('success', $todb->id);
    }

    public function update(Request $request, $id)
    {
        $validasi = $this->validate($request, [
            'judul'     => 'required|string|max:200',
            'isi'       => 'required|string',
            'gambar'    => 'image|mimes:jpeg,png,jpg|max:3072',
            'kategori'  => 'required'
        ]);

        $data = Berita::findOrFail($id);

        $data->judul     = $request->judul;
        $data->isi       = $request->isi;
        $input = "";
        foreach($request->kategori as $ktg)   {  
            $input .= $ktg.",";  
        } 
        $data->kategori  = $input;

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

    public function delete($id) //delete berita
    {
        $data = Berita::findOrFail($id);
        if ($data->gambar && file_exists(storage_path('app/public/' . $data->gambar))) {
            \Storage::delete('public/' . $data->gambar);
        }
        $data->delete();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menghapus Berita.'
        );
    }

    public function tableBerita() // api table berita untuk datatable
    {
        $data = Berita::select('beritas.id', 'beritas.judul', DB::raw('group_concat(concat(kategori_beritas.nama)SEPARATOR ", ") as kategori'))
        ->leftjoin("kategori_beritas",\DB::raw("FIND_IN_SET(kategori_beritas.id,beritas.kategori)"),">",\DB::raw("'0'"))
        ->groupBy('beritas.id')
        ->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a href='berita/show/".$data->id."' class='btn btn-info btn-xs' 
            title='detail berita'
            >
            <i class='fa fa-eye'></i>
            </a>

            <a href='berita/edit/".$data->id."' class='btn btn-success btn-xs'>
            <i class='fa fa-edit'></i>
            </a>

            <button class='btn btn-danger btn-xs'
            title='Hapus Berita' 
            href='berita/delete-berita/".$data->id."'
            onclick='hapus_data()'
            id='del_id'
            >
            <i class='fa fa-trash'></i>
            </button>";
        })
        ->addIndexColumn() 
        ->make(true);
    }


    // BAGIAN KATEGORI BERITA 
    public function kategori() //halaman kategori berita
    {
        return view('admin.berita.kategori');
    }

    public function postKategori(Request $request)
    {
        $validasi = $this->validate($request, [
            'nama'  => 'required|string'
        ]);

        $data = new KategoriBerita;
        $data->nama = $request->nama;
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menambah Kategori Berita.'
        );
    }

    public function editKategori(Request $request)
    {
        $validasi = $this->validate($request, [
            'nama'  => 'required|string'
        ]);

        $data = KategoriBerita::find($request->hidden_id);
        if($data == '') {
            return $arrayName = array(
                'status' => 'error',
                'pesan' => 'Data kategori berita tidak ditemukan'
            );
        }
        $data->nama = $request->nama;
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Mengubah Kategori Berita.'
        );
    }

    public function deleteKategori(Request $request, $id) //delete kategori berita
    {
        $data = KategoriBerita::find($request->id);
        if($data == '') {
            return $arrayName = array(
                'status' => 'error',
                'pesan' => 'Data kategori berita tidak ditemukan'
            );
        }
        $data->delete();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menghapus Kategori Berita.'
        );
    }

    public function tableKategori() // api table kategori berita untuk datatable
    {
        $data = KategoriBerita::select('id', 'nama')
        ->orderBy('created_at', 'desc')
        ->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a href='' class='btn btn-success btn-xs'
            data-toggle='modal' 
            data-target='#modal-edit-kategori'
            title='edit kategori berita'
            data-id='".$data->id."'
            data-nama='".$data->nama."'>
            <i class='fa fa-edit'></i>
            </a>

            <button class='btn btn-danger btn-xs'
            title='Hapus Pengecer' 
            href='delete-kategori/".$data->id."'
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
