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
        ->select('feeds.id', 'feeds.post_id', 'feeds.publisher', 'feeds.status', 'feeds.gambar', 'users.id as user_id', 'users.name', DB::raw('DATE_FORMAT(feeds.created_at, "%H:%i %d %b %Y") as created_at'))
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

    public function myfeed(Request $request)
    {
        // return 'hha';
        $validator = Validator::make($request->all(), [
            'user_id'  => 'required|numeric',
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

        $data = DB::table('feeds')
        ->select('feeds.id', 'feeds.post_id', 'feeds.publisher', 'feeds.status', 'feeds.gambar', 'users.id as user_id', 'users.name', DB::raw('DATE_FORMAT(feeds.created_at, "%H:%i %d %b %Y") as created_at'))
        ->join('users', 'feeds.user_id', '=', 'users.id')
        ->orderBy('feeds.created_at', 'desc')
        ->where('feeds.user_id', $request->user_id)
        ->paginate(15);

        return response()->json([
            'status' => true,
            'message'   => 'My Feed limit 15 data', 
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

    public function detail(Request $request) //detail feed
    {
        // return 'hha';
        $validator = Validator::make($request->all(), [
            'feed_id'  => 'required|numeric',
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $data = DB::table('feeds')
        ->select('feeds.id', 'feeds.post_id', 'feeds.publisher', 'feeds.status', 'feeds.gambar', 'users.id as user_id', 'users.name', DB::raw('DATE_FORMAT(feeds.created_at, "%H:%i %d %b %Y") as created_at'))
        ->join('users', 'feeds.user_id', '=', 'users.id')
        ->orderBy('feeds.created_at', 'desc')
        ->where('feeds.id', $request->feed_id)
        ->get();
        if($data == '') {
            return response()->json([
                'status' => false,
                'message' => 'tidak ada data'
            ]);
        }
        return response()->json([
            'status' => true,
            'message'   => 'detail feed', 
            'data'  => $data
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
        $data->post_id = $request->post_id;
        $data->publisher = $request->publisher;
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

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'  => 'required|numeric',
            'feed_id'   => 'required|numeric',
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

        $data = Feed::find($request->feed_id);
        if($data == '') {
            return response()->json([
                'status' => false,
                'message' => 'id feed tidak ditemukan'
            ]);
        }
        if($data->user_id == $request->user_id && $data->id == $request->feed_id) {
            $data->delete();
            return response()->json([
                'status'    => true,
                'message'   => 'Berhasil menghapus feed',
            ]);
        } 
        return response()->json([
            'status'    => false,
            'message'   => 'feed ini bukan milik Anda',
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
