<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\WebCreature;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class KillStatisticsController extends Controller
{
    public const CACHE_KILL_STATISTICS_KEY = 'statistic:kills';

    public function index(): View
    {
        $killStatistics = self::getStatistics();
        $lastUpdatedTime = Cache::get(self::CACHE_KILL_STATISTICS_KEY . ':time');
        return view(
            'community.kill-statistics.index',
            compact(
                'killStatistics',
                'lastUpdatedTime'
            )
        );
    }

    public static function getStatistics()
    {
        if(!Cache::has(self::CACHE_KILL_STATISTICS_KEY)) {
            self::cacheStatistics();
        }
        return Cache::get(self::CACHE_KILL_STATISTICS_KEY);
    }

    public static function cacheStatistics(): void
    {
        $serverSaveTime = config('server.serverSaveTime');
        $yesterday = Carbon::yesterday()->setTimeFromTimeString($serverSaveTime)->timestamp;
        $lastWeek = Carbon::now()->subWeek()->setTimeFromTimeString($serverSaveTime)->timestamp;

        $creatures = WebCreature::with(['killStatistics' => function ($query) {
            $query->join('web_creatures', function($join) {
                $join->on('web_creatures.name', '=', 'kill_statistics.name')
                    ->whereRaw('LOWER(web_creatures.name) = LOWER(kill_statistics.name)');
            });
        }])->get();

        $statistics = [];
        foreach ($creatures as $creature) {
            $statistics[$creature->name]['lastDay'] = $creature->killStatistics->filter(function($statistic) use ($yesterday) {
                return $statistic->time > $yesterday;
            });
            $statistics[$creature->name]['lastWeek'] = $creature->killStatistics->filter(function($statistic) use ($yesterday, $lastWeek) {
                return $statistic->time <= $yesterday && $statistic->time > $lastWeek;
            });
        }
        $nextDayAtTenAM = Carbon::tomorrow()->setTime(10, 0);
        $currentTime = Carbon::now();
        $minutesUntilNextDayAtTenAM = $nextDayAtTenAM->diffInMinutes($currentTime);
        Cache::put(self::CACHE_KILL_STATISTICS_KEY, $statistics, $minutesUntilNextDayAtTenAM);
        Cache::put(self::CACHE_KILL_STATISTICS_KEY . ':time', now(), $minutesUntilNextDayAtTenAM);
    }
}
