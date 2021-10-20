<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notification;
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
}
