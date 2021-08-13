<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Feed;
use DB;
class FeedController extends Controller
{
    public function index()
    {
        $data = DB::table('feeds')
                ->select('feeds.id', 'feeds.status', 'feeds.gambar', 'users.name', 'feeds.created_at')
                ->join('users', 'feeds.user_id', '=', 'users.id')
                ->orderBy('feeds.created_at', 'desc')
                ->paginate(15);

        return response()->json([
            'status' => true,
            'message'   => 'Feed limit 15 data', 
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'  => 'required|numeric',
            'status'   => 'required|string',
            'gambar'   => 'image|mimes:jpeg,png,jpg|max:3072',
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
        
        if($this->login($request->user_id) == false) {
            return $this->error;
        }

        $data = new Feed;
        $data->status = $request->status;
        $data->user_id = $request->user_id;

        $gambar = $request->file('gambar');
        if ($gambar) {
            $gambar_path = $gambar->store('gambar', 'public');
            $data->gambar = $gambar_path;
        }
        $data->save();

        return response()->json([
            'status'    => true,
            'message'   => 'Berhasil memposting',
        ]);
    }

    private $user;
    private $error;

    public function login($id)
    {
        $this->user = User::find($id);
        if($this->user == '') {
            $this->error = [
                'status'    => false,
                'message'   => 'Id Alumni Tidak ditemukan'
            ]; 
            return false;
        } else if ($this->user->is_active != '1') {
            $this->error = [
                'status'    => false,
                'message'   => 'Anda Bukan Alumni Dipa'
            ]; 
            return false;
        }
        return true;
    }
}
