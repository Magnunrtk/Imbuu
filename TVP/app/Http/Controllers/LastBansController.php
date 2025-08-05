<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountBan;
use Carbon\Carbon;
use App\Models\Player;

class LastBansController extends Controller
{
    public function index()
    {
        $bans = AccountBan::select('account_id', 'reason', 'banned_at', 'expires_at', 'banned_by')
        ->with(['player' => function ($query) {
            $query->orderByDesc('level')->select('name', 'account_id', 'level');
        }])
        ->with('admin')
        ->orderBy('banned_at', 'desc')
        ->get();
    
        foreach ($bans as $ban) {
            $ban->banned_at_formatted = Carbon::createFromTimestamp($ban->banned_at)->format('d, M, Y H:i:s');
            $ban->expires_at_formatted = Carbon::createFromTimestamp($ban->expires_at)->format('d, M, Y H:i:s');

            $ban->player_name = optional($ban->player)->name ?? 'Not found';
            $ban->player_level = optional($ban->player)->level ?? 'N/A';

            $ban->adm_name = optional($ban->admin)->name ?? 'Not found';
        }
    
        return view('community.last-bans.index', compact('bans'));
    }
}
