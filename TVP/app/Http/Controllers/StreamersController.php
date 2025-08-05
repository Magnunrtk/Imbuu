<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class StreamersController extends Controller
{
    public function index(): View
    {
        
        if(true){ // !Cache::has('twitchstreams')
            Artisan::call('cache:streamers:twitch');
        }
    
        $streamersList = Cache::get('twitchstreams');

        usort($streamersList, function($a, $b) {
            if ($a['online'] && !$b['online']) {
                return -1;
            } elseif (!$a['online'] && $b['online']) {
                return 1;
            }
            return 0;
        });

        return view('community.streamers.index', compact('streamersList'));
    }
}
