<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Fcmtoken;
use Validator;
class FcmtokenController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token'  => 'required|string',
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
              'status' => false,
              'message' => $message
          ]);
        }

        $data = new Fcmtoken;
        $data->token = $request->token;
        $data->save();
        return response()->json([
            'status' => true,
            'message' => 'Token disimpan'
        ]);
    }

    public function delete(Request $request) // hapus token (revoke)
    {
        $validator = Validator::make($request->all(), [
            'token'  => 'required|string',
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
              'status' => false,
              'message' => $message
          ]);
        }

        $data = Fcmtoken::where('token', $request->token)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Token dihapus'
        ]);
    }
}
