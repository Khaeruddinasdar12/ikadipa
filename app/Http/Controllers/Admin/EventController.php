<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use Auth;
use DataTables;
use DB;
use App\Fcmtoken;
class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        // $data = Event::orderBy('created_at', 'desc')->paginate(2);

        return view('admin.event.index');
    }
    public function riwayat()
    {
        // $data = Event::orderBy('created_at', 'desc')->paginate(2);

        return view('admin.event.riwayat');
    }

    public function create()
    {
        return view('admin.event.create');
    }

    public function edit($id)
    {
        $data = DB::table('events')->find($id);
        if($data == '') {
            abort(404);
        }        

        return view('admin.event.edit', ['data' => $data]);
    }

    public function store(Request $request)
    {
        $validasi = $this->validate($request, [
            'nama'          => 'required|string|max:100',
            'deskripsi'     => 'required|string',
            'date_start'    => 'required|date',
            'date_end'      => 'required|date',
            'time_start'    => 'required|string|max:20',
            'time_end'      => 'required|string|max:20',
            'lokasi'    => 'required|string|max:100',
            'gambar'    => 'image|mimes:jpeg,png,jpg|max:3072'
        ]);

        if ( strtotime($request->date_start) > strtotime($request->date_end) ) {
            return redirect()->back()->with('error', 'Tanggal mulai tidak boleh lebih dari tanggal akhir');
        }
        $data = new Event;
        $data->nama      = $request->nama;
        $data->deskripsi = $request->deskripsi;
        $data->date_start= $request->date_start;
        $data->date_end  = $request->date_end;
        $data->time_start= $request->time_start;
        $data->time_end  = $request->time_end;
        $data->lokasi    = $request->lokasi;
        $data->status = '0';


        $gambar = $request->file('gambar');
        if ($gambar) {
            $gambar_path = $gambar->store('gambar', 'public');
            $data->gambar = $gambar_path;
        }

        $data->admin_id = Auth::guard('admin')->user()->id;
        $data->save();

        $firebaseToken = Fcmtoken::pluck('token')->all();
        $fcm_key = config('app.fcm_key');
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => "Event! ".$request->nama,
                "body" => "Di ". $request->deskripsi,  
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

        return redirect()->back()->with('success', $data->id);
    }

    public function update(Request $request, $id)
    {
        $validasi = $this->validate($request, [
            'nama'          => 'required|string|max:100',
            'deskripsi'     => 'required|string',
            'date_start'    => 'required|date',
            'date_end'      => 'required|date',
            'time_start'    => 'required|string|max:20',
            'time_end'      => 'required|string|max:20',
            'lokasi'    => 'required|string|max:100',
            'gambar'    => 'image|mimes:jpeg,png,jpg|max:3072'
        ]);
        if ( strtotime($request->date_start) > strtotime($request->date_end) ) {
            return redirect()->back()->with('error', 'Tanggal mulai tidak boleh lebih dari tanggal akhir');
        }
        
        $data = Event::findOrFail($id);
        $data->nama      = $request->nama;
        $data->deskripsi = $request->deskripsi;
        $data->date_start= $request->date_start;
        $data->date_end  = $request->date_end;
        $data->time_start= $request->time_start;
        $data->time_end  = $request->time_end;
        $data->lokasi    = $request->lokasi;

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

    public function delete($id)
    {
        $data = Event::findOrFail($id);
        if ($data->gambar && file_exists(storage_path('app/public/' . $data->gambar))) {
            \Storage::delete('public/' . $data->gambar);
        }
        $data->delete();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menghapus Event.'
        );
    }

    public function ubahStatus($id)
    {
        $data = Event::findOrFail($id);
        $data->status = '1';
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Event telah selesai.'
        );
    }

    public function tableEvent() // api table event untuk datatable
    {
        $data = Event::select('id', 'nama', 'deskripsi', 'date_start', 'date_end', 'time_start', 'time_end', 'lokasi', 'gambar')
        ->where('status', '0')
        ->orderBy('date_start', 'asc')
        ->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a href='' class='btn btn-info btn-xs' 
            title='detail event'
            data-toggle='modal' 
            data-target='#modal-detail-event'
            data-id='".$data->id."'
            data-nama='".$data->nama."'
            data-waktu='".$data->date_start." ".$data->time_start." - ".$data->date_end." ".$data->time_end."'
            data-lokasi='".$data->lokasi."'
            data-deskripsi='".$data->deskripsi."'
            data-gambar='".$data->gambar."'
            >
            <i class='fa fa-eye'></i>
            </a>

            <a href='event/edit/".$data->id."' class='btn btn-success btn-xs' title='sunting event'>
            <i class='fa fa-edit'></i>
            </a>

            <button class='btn btn-warning btn-xs'
            title='event selesai ?' 
            href='event/status-event/".$data->id."'
            onclick='status_event()'
            id='status_id'
            >
            <i class='fa fa-check-circle'></i>
            </button>

            <button class='btn btn-danger btn-xs'
            title='hapus event' 
            href='event/delete-event/".$data->id."'
            onclick='hapus_data()'
            id='del_id'
            >
            <i class='fa fa-trash'></i>
            </button>";
        })
        ->editColumn('date_start', function($data){
            return $data->date_start." ".$data->time_start;
        })
        ->editColumn('date_end', function($data){
            return $data->date_end." ".$data->time_end;
        })
        ->addIndexColumn() 
        ->make(true);
    }

    public function tableRiwayatEvent() // api table riwayat event untuk datatable
    {
        $data = Event::select('id', 'nama', 'deskripsi', 'date_start', 'date_end', 'time_start', 'time_end', 'lokasi', 'gambar')
        ->where('status', '1')
        ->orderBy('date_start', 'asc')
        ->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a href='' class='btn btn-info btn-xs' 
            title='detail event'
            data-toggle='modal' 
            data-target='#modal-detail-event'
            data-id='".$data->id."'
            data-nama='".$data->nama."'
            data-waktu='".$data->date_start." ".$data->time_start." - ".$data->date_end." ".$data->time_end."'
            data-lokasi='".$data->lokasi."'
            data-deskripsi='".$data->deskripsi."'
            data-gambar='".$data->gambar."'
            >
            <i class='fa fa-eye'></i>
            </a>

            <button class='btn btn-danger btn-xs'
            title='hapus event' 
            href='event/delete-event/".$data->id."'
            onclick='hapus_data()'
            id='del_id'
            >
            <i class='fa fa-trash'></i>
            </button>";
        })
        ->editColumn('date_start', function($data){
            return $data->date_start." ".$data->time_start;
        })
        ->editColumn('date_end', function($data){
            return $data->date_end." ".$data->time_end;
        })
        ->addIndexColumn() 
        ->make(true);
    }
}
