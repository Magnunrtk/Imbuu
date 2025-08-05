<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TwitchLiveController extends Controller
{
    public function liveTimes(Request $request)
    {
        $streamers = DB::table('webhook_streamers')->get();
        $horas     = DB::table('streamer_hours')->get();

        return view('admin.streamer_references.live_times', compact('streamers', 'horas'));
    }
}
