<?php

declare(strict_types=1);

namespace App\Utils;

use App\Models\Player;
use Illuminate\Support\Facades\Cache;

class TopPlayersCache
{
    private static string $cacheKey = 'top:players';

    public static function get(): string
    {
        if (!Cache::has(self::$cacheKey)) {
            self::cache();
        }
        return Cache::get(self::$cacheKey);
    }

    public static function set(Object $topPlayers): void
    {
        Cache::put(self::$cacheKey, $topPlayers);
    }

    public static function cache(): void
    {
        $players = Player::select('name', 'vocation', 'level', 'experience', 'lookbody', 'lookfeet', 'lookhead', 'looklegs', 'looktype', 'direction')
            ->where('group_id', '<', '3')
            ->orderBy('experience', 'desc')
            ->limit(5)
            ->get();
        Cache::put(
            self::$cacheKey,
            json_encode($players),
        );
    }
}
