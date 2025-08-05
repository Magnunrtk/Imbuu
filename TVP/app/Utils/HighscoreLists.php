<?php

declare(strict_types=1);

namespace App\Utils;

use App\Models\Player;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Collection;

class HighscoreLists
{
    public const CACHE_EXPERIENCE_LIST_KEY = 'highscore:list:experience';
    public const CACHE_AXE_LIST_KEY = 'highscore:list:axe';
    public const CACHE_CLUB_LIST_KEY = 'highscore:list:club';
    public const CACHE_DISTANCE_LIST_KEY = 'highscore:list:distance';
    public const CACHE_FISHING_LIST_KEY = 'highscore:list:fishing';
    public const CACHE_FISTING_LIST_KEY = 'highscore:list:fisting';
    public const CACHE_MAGIC_LIST_KEY = 'highscore:list:magic';
    public const CACHE_SHIELDING_LIST_KEY = 'highscore:list:shielding';
    public const CACHE_SWORD_LIST_KEY = 'highscore:list:sword';

    public static function getAllHighscores(int $worldId): array
    {
        return [
            'experience' => self::getHighscoreList(self::CACHE_EXPERIENCE_LIST_KEY, $worldId),
            'axe' => self::getHighscoreList(self::CACHE_AXE_LIST_KEY, $worldId),
            'club' => self::getHighscoreList(self::CACHE_CLUB_LIST_KEY, $worldId),
            'distance' => self::getHighscoreList(self::CACHE_DISTANCE_LIST_KEY, $worldId),
            'fishing' => self::getHighscoreList(self::CACHE_FISHING_LIST_KEY, $worldId),
            'fisting' => self::getHighscoreList(self::CACHE_FISTING_LIST_KEY, $worldId),
            'magic' => self::getHighscoreList(self::CACHE_MAGIC_LIST_KEY, $worldId),
            'shielding' => self::getHighscoreList(self::CACHE_SHIELDING_LIST_KEY, $worldId),
            'sword' => self::getHighscoreList(self::CACHE_SWORD_LIST_KEY, $worldId),
        ];
    }

    public static function getFilteredHighscores(int $worldId): array
    {
        $highscores = [];

        foreach (config('vocations') as $vocationKey => $vocation) {
            if (isset($vocation['parent_id'])) {
                continue;
            }
            $highscores[$vocationKey]['experience'] = self::getHighscoreList(self::CACHE_EXPERIENCE_LIST_KEY, $worldId, [$vocationKey]);
            $highscores[$vocationKey]['axe'] = self::getHighscoreList(self::CACHE_AXE_LIST_KEY, $worldId, [$vocationKey]);
            $highscores[$vocationKey]['club'] = self::getHighscoreList(self::CACHE_CLUB_LIST_KEY, $worldId, [$vocationKey]);
            $highscores[$vocationKey]['distance'] = self::getHighscoreList(self::CACHE_DISTANCE_LIST_KEY, $worldId, [$vocationKey]);
            $highscores[$vocationKey]['fishing'] = self::getHighscoreList(self::CACHE_FISHING_LIST_KEY, $worldId, [$vocationKey]);
            $highscores[$vocationKey]['fisting'] = self::getHighscoreList(self::CACHE_FISTING_LIST_KEY, $worldId, [$vocationKey]);
            $highscores[$vocationKey]['magic'] = self::getHighscoreList(self::CACHE_MAGIC_LIST_KEY, $worldId, [$vocationKey]);
            $highscores[$vocationKey]['shielding'] = self::getHighscoreList(self::CACHE_SHIELDING_LIST_KEY, $worldId, [$vocationKey]);
            $highscores[$vocationKey]['sword'] = self::getHighscoreList(self::CACHE_SWORD_LIST_KEY, $worldId, [$vocationKey]);
        }

        return $highscores;
    }

    public static function getHighscoreList(string $cacheKey, int $worldId, array $vocations = []): Collection
    {
        if (empty($vocations)) {
            $vocations = array_keys(config('vocations'));
        } else {
            foreach ($vocations as $vocationId) {
                $vocations = array_merge($vocations, config('vocations')[$vocationId]['child_id'] ?? [], config('vocations')[$vocationId]['parent_id'] ?? []);
            }
            $vocations = array_unique($vocations);
            sort($vocations);
        }

        $skillColumn = self::getSkillByCacheKey($cacheKey);

        return Player::select('name', 'vocation', 'level', $skillColumn . ' as skill')
            ->leftJoin('account_bans', 'players.account_id', '=', 'account_bans.account_id')
            ->where(function ($query) {
                $query->whereNull('account_bans.account_id')
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('account_bans.expires_at', '<=', time())
                                ->where('account_bans.expires_at', '!=', 0);
                    });
            })
            ->where('group_id', '<', 3)
            ->whereIn('vocation', $vocations)
            //->where('world_id', '=', $worldId)
            ->orderBy('skill', 'desc')
            ->limit(config('highscore.listLimit'))
            ->get();
    }

    private static function getSkillByCacheKey(string $cacheKey): string
    {
        return match ($cacheKey) {
            self::CACHE_AXE_LIST_KEY => 'skill_axe',
            self::CACHE_CLUB_LIST_KEY => 'skill_club',
            self::CACHE_DISTANCE_LIST_KEY => 'skill_dist',
            self::CACHE_EXPERIENCE_LIST_KEY => 'experience',
            self::CACHE_FISHING_LIST_KEY => 'skill_fishing',
            self::CACHE_MAGIC_LIST_KEY => 'maglevel',
            self::CACHE_SHIELDING_LIST_KEY => 'skill_shielding',
            self::CACHE_SWORD_LIST_KEY => 'skill_sword',
            self::CACHE_FISTING_LIST_KEY => 'skill_fist',
            default => throw new InvalidArgumentException("Invalid cache key: $cacheKey"),
        };
    }
}
