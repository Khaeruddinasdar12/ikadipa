<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;
use Validator;
class EventController extends Controller
{
    public function event(Request $request)
    {
        $data = Event::orderBy('created_at', 'desc')
        ->paginate(10);

        return response()->json([
            'status' => true,
            'message'   => 'List Event, limit 10 data',
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

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|numeric',
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $data = Event::find($request->event_id);
        if($data == '') {
            return response()->json([
                'status' => false,
                'message' => 'id event tidak ditemukan'
            ]);
        }

        return response()->json([
            'status' => true,
            'message'   => 'Detail Event',
            'data'  => $data
        ]);
    }
}
