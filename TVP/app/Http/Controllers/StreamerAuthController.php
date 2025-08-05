<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Streamer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StreamerAuthController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $streamer = Streamer::where('account_associate', $userId)->first();
    
        if ($streamer) {
            Session::put('streamer_id', $streamer->id);
            Session::put('streamer_name', $streamer->name);
            return redirect()->route('account.manage.streamer.dashboard');
        }
    
        return view('account.manage.streamer.login');
    }
    

    public function login(Request $request)
    {
        $request->validate([
            'streamer_name' => 'required|string',
            'access_code' => 'required|string',
        ]);

        $streamer = Streamer::where('name', $request->streamer_name)->first();

        if ($streamer && $streamer->code === $request->access_code) {

            Session::put('streamer_id', $streamer->id);
            Session::put('streamer_name', $streamer->name);

            return redirect()->route('account.manage.streamer.dashboard');
        }

        return back()->withErrors(['login_error' => 'Invalid streamer name or access code.']);
    }

    public function logout()
    {
        Session::forget('streamer_id');
        Session::forget('streamer_name');

        return redirect()->route('account.manage.streamer.login');
    }
}
