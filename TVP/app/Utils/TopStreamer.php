<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Support\Facades\Cache;

class TopStreamer
{
    public static function get()
    {
        $streamersList = [];
        if (Cache::has('twitchstreams')) {
            $streamersList = Cache::get('twitchstreams');
        }
        $streamersWithGameId1000 = collect($streamersList)
            ->where('game_id', config('streamers.settings.gameID')[0])
            ->all();
        $streamerWithMostViews = collect($streamersWithGameId1000)->max('view_count');
        return collect($streamersList)->first(function ($streamer) use ($streamerWithMostViews) {
            return $streamer['view_count'] === $streamerWithMostViews && $streamer['online'] === true;
        });
    }
}
