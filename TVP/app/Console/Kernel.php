<?php

declare(strict_types=1);

namespace App\Console;

use App\Console\Commands\CacheHighscoreLists;
use App\Console\Commands\CacheKillStatistics;
use App\Console\Commands\CachePlayersOnline;
use App\Console\Commands\CacheTwitchStreamerList;
use App\Console\Commands\ChangeEmailFinalize;
use App\Console\Commands\CleanLostPasswordTable;
use App\Console\Commands\DatabaseBackup;
use App\Console\Commands\DisbandOrActivateGuilds;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /** @var array */
    protected $commands = [
        DisbandOrActivateGuilds::class,
        ChangeEmailFinalize::class,
        DatabaseBackup::class,
        CleanLostPasswordTable::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        /*
        $schedule->command(CacheTopPlayers::class)
            ->withoutOverlapping()
            ->everyFiveMinutes();
        $schedule->command(CacheServerStatus::class)
            ->withoutOverlapping()
            ->everyMinute();
        $schedule->command(DisbandOrActivateGuilds::class)
            ->withoutOverlapping()
            ->daily()
            ->at(config('server.serverSaveTime'));
        $schedule->command(DatabaseBackup::class)
            ->withoutOverlapping()
            ->daily()
            ->at(config('server.serverSaveTime'));
        */
        $schedule->command(CacheTwitchStreamerList::class)
            ->withoutOverlapping()
            ->everyThirtyMinutes();
        $schedule->command(CacheHighscoreLists::class)
            ->withoutOverlapping()
            ->everyFifteenMinutes();
        $schedule->command(CachePlayersOnline::class)
            ->withoutOverlapping()
            ->everyFiveMinutes();
        $schedule->command(ChangeEmailFinalize::class)
            ->withoutOverlapping()
            ->hourly();
        $schedule->command(CleanLostPasswordTable::class)
            ->withoutOverlapping()
            ->daily();
        $schedule->command(CacheKillStatistics::class)
            ->withoutOverlapping()
            ->daily()
            ->at('10:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
