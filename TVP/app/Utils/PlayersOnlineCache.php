<?php

declare(strict_types=1);

namespace App\Utils;

use App\Models\PlayersOnline;
use App\Models\WebOnlineStatistics;
use Illuminate\Support\Facades\Cache;

class PlayersOnlineCache
{
    public static function get(int $worldId): int
    {
        $cacheKey = self::getCacheKeyByWorld($worldId);

        if (!Cache::has($cacheKey)) {
            self::cache($worldId);
        }
        return Cache::get($cacheKey);
    }

    public static function getFromAllWorlds(): int
    {
        $worlds = config('game.worlds');
        $totalPlayerCount = 0;

        foreach ($worlds as $world) {
            $worldId = $world['id'];
            $cacheKey = self::getCacheKeyByWorld($worldId);

            if (!Cache::has($cacheKey)) {
                self::cache($worldId);
            }

            $playerCount = Cache::get($cacheKey);
            $totalPlayerCount += $playerCount;
        }

        return $totalPlayerCount;
    }

    public static function set(int $worldId, int $playersOnline): void
    {
        $cacheKey = self::getCacheKeyByWorld($worldId);
        WebOnlineStatistics::create([
           'player_count' => $playersOnline,
            'world_id' => $worldId,
        ]);
        Cache::put($cacheKey, $playersOnline);
    }

    public static function cache(int $worldId): void
    {
        $cacheKey = self::getCacheKeyByWorld($worldId);

        if (!Cache::has($cacheKey)) {
            //$totalPlayers = PlayersOnline::where('world_id', $worldId)->count();
            $totalPlayers = PlayersOnline::all()->count();
            Cache::put($cacheKey, $totalPlayers);
        }
    }

    public static function getAll(): int
    {
        $cacheKey = self::getCacheKeyAll();

        if(true) { //!Cache::has($cacheKey)
            self::cacheAll();
        }

        return Cache::get($cacheKey);
    }

    public static function cacheAll(): void
    {
        $cacheKey = self::getCacheKeyAll();
    
        $totalPlayers = PlayersOnline::whereNotIn('player_id', [1, 36, 37, 4792])->count();
        
        Cache::put($cacheKey, $totalPlayers);
    }
    

    private static function getCacheKeyByWorld(int $worldId): string
    {
        return 'server:playersOnline:' . $worldId;
    }

    private static function getCacheKeyAll(): string
    {
        return 'server:playersOnline';
    }
}
