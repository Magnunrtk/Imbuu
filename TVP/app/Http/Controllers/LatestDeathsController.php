<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PlayerDeath;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class LatestDeathsController extends Controller
{
    public function index(): View
    {
        //$fifteenMinutesDelay = Carbon::now()->subMinutes(15)->timestamp;
        //$latestDeaths = PlayerDeath::where('time', '<', $fifteenMinutesDelay)->orderBy('time', 'desc')->with('player')->limit(100)->get();
        $latestDeaths = PlayerDeath::orderBy('time', 'desc')->with('player')->limit(100)->get();
        return view('community.deaths.index', compact('latestDeaths'));
    }
}
