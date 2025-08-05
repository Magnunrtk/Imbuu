<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Guild;
use App\Utils\GuildRanks;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DisbandOrActivateGuilds extends Command
{
    /** @var string */
    protected $signature = 'guilds:disband-activate';

    /** @var string */
    protected $description = 'Disband guilds with less than four vice leaders, activate others';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            $guilds = Guild::where('creationdata', '<=', Carbon::now()
                ->subDays(3)
                ->timestamp)
                ->with('members', 'members.ranks')
                ->get();

            foreach ($guilds as $guild) {
                $viceLeaders = 0;
                foreach($guild->members as $member) {
                    if($member->ranks->level === GuildRanks::VICE_LEADER_LEVEL) {
                        $viceLeaders++;
                    }
                }

                if($viceLeaders < GuildRanks::MINIMUM_VICE_LEADERS) {
                    Guild::find($guild->id)->delete();
                } else {
                    $guild->activ = true;
                    $guild->save();
                }
            }
            $this->info('Guilds processed. Inactive guilds disbanded, others activated.');
        } catch (\Exception $e) {
            $message = $e->getMessage() . PHP_EOL . PHP_EOL . $e->getTraceAsString();
            $this->error($message);
            Log::error($message);
        }
    }
}
