<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;

class EventController extends Controller
{
    public function event(Request $request)
    {
        $data = Event::orderBy('created_at', 'desc')
        ->paginate(10);

        return response()->json([
            'status'    => true,
            'message'   => 'List Event, limit 10 data',
            'data'      => $data,
        ]);
    }
}
