<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notification;
use App\Fcmtoken;
use DataTables;
class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        return view('admin.notification.index');
    }
    public function store(Request $request)
    {
        $validasi = $this->validate($request, [
            'judul'     => 'required|string|max:200',
            'deskripsi'    => 'required|string|max:200',
        ]);

        $todb = new Notification;
        $todb->judul = $request->judul;
        $todb->deskripsi = $request->deskripsi;
        $todb->save();

        $firebaseToken = Fcmtoken::pluck('token')->all();
        $fcm_key = config('app.fcm_key');
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->judul,
                "body" => $request->deskripsi,  
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

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Mengirim Notifikasi.'
        );
    }
    public function tableNotification() // api table notifications
    {
        $data = Notification::get();

        return Datatables::of($data)
        // ->addColumn('action', function ($data) {
        //     return "
        //     <a href='show/".$data->id."' title='detail alumni' class='btn btn-info btn-xs'>
        //     <i class='fa fa-edit'></i>
        //     </a>

        //     <button class='btn btn-danger btn-xs'
        //     title='Hapus Donasi' 
        //     href='donasi/delete-donasi/".$data->id."'
        //     onclick='hapus_data()'
        //     id='del_id'
        //     >
        //     <i class='fa fa-trash'></i>
        //     </button>";
        // })
        ->addIndexColumn() 
        ->make(true);
    }

    public function sendNotification(Request $request) //tes, 
    {
        // ke db MySQL
        $data = new Notification;
        $data->judul = $request->judul;
        $data->deskripsi = $request->deskripsi;
        $data->save();

        $firebaseToken = Fcmtoken::pluck('token')->all();
        $fcm_key = config('app.fcm_key');
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->judul,
                "body" => $request->deskripsi,  
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
        
        return 
        dd($response);
    }
}
