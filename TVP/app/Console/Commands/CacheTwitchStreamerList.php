<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use TwitchApi\HelixGuzzleClient;
use TwitchApi\TwitchApi;

class CacheTwitchStreamerList extends Command
{
    /** @var string */
    protected $signature = 'cache:streamers:twitch';

    /** @var string */
    protected $description = 'Cache all twitch streamers for the server';

    private $helixGuzzleClient = null;
    private $twitchApi = null;
    private $oauthApi = null;

    public function __construct()
    {
        $this->helixGuzzleClient = new HelixGuzzleClient(config('streamers.settings.clientID'));
        $this->twitchApi = new TwitchApi($this->helixGuzzleClient, config('streamers.settings.clientID'), config('streamers.settings.clientSecret'));
        $this->oauthApi = $this->twitchApi->getOauthApi();
        parent::__construct();
    }

    public function handle(): void
    {
        try {
            $this->updateStreamsCache();
            $this->info('All twitch streamers has been updated.');
        } catch (\Exception $e) {
            $message = $e->getMessage() . PHP_EOL . PHP_EOL . $e->getTraceAsString();
            $this->error($message);
            Log::error($message);
        }
    }

    public function getBearerToken(): string
    {
        $token = Cache::has('twitchapptoken');
        if (!$token) {
            $this->generateBearerToken();
        }
        return Cache::get('twitchapptoken')['token'];
    }

    public function getTwitchApi() {
        return $this->twitchApi;
    }

    private function generateBearerToken() {
        $tokenRequest = $this->oauthApi->getAppAccessToken("");
        $data = json_decode($tokenRequest->getBody()->getContents());

        $cacheData = [
            "token" => $data->access_token,
            "expires" => $data->expires_in + time()
        ];
        //Cache for 2 month
        Cache::put('twitchapptoken', $cacheData, Carbon::now()->endOfMonth());
    }

    public function updateStreamsCache() {
        $streams = Cache::get('twitchstreams');
        if (!Cache::has('twitchstreams')) {
            $streams = [];
        }

        // Remove inactive streamers
        foreach ($streams as $userId => $stream) {
            if (!isset($stream['online']))
                continue;
            if ($stream['online'] !== true && $stream['last_seen'] < time() - config('streamers.settings.allowedInactivity')) {
                unset($streams[$userId]);
            }
        }

        // Assume everyone is offline, until we verify otherwise
        foreach ($streams as $userId => $stream) {
            $streams[$userId]['online'] = false;
        }

        $cursor = null;
        $limit = 100;

        do {
            if (!empty(config('streamers.usernames'))) {
                $response = $this->getTwitchApi()->getStreamsApi()->getStreams($this->getBearerToken(), [], config('streamers.usernames'), config('streamers.settings.gameID'), [], $limit, null, $cursor);
            } else {
                $response = $this->getTwitchApi()->getStreamsApi()->getStreams($this->getBearerToken(), [], [], config('streamers.settings.gameID'), [], $limit, null, $cursor);
            }
            $responseContent = json_decode($response->getBody()->getContents(), true);
            $cursor = $responseContent["pagination"]["cursor"] ?? null;

            foreach ($responseContent["data"] as $stream) {
                $streamTitle = Str::lower($stream["title"]);
                if (empty(config('streamers.usernames'))) {
                    foreach (config('streamers.settings.titleKeywords') as $keyword) {
                        $userId = $stream["user_id"];
                        if (preg_match("/$keyword/", $streamTitle)) {
                            $stream["last_seen"] = time();
                            $stream["online"] = true;
                            $streams[$userId] = $stream;
                            break;
                        } else {
                            unset($streams[$userId]);
                        }
                    }
                } else {
                    $userId = $stream["user_id"];
                    $stream["last_seen"] = time();
                    $stream["online"] = true;
                    $streams[$userId] = $stream;
                }
            }
        } while ($cursor);

        $onlineStreams = array_keys(array_filter($streams, function($stream) {
            return array_key_exists('online', $stream) && $stream['online'] === true;
        }));
        $limit = min(count($onlineStreams), 100);
        $i = 0;
        if (!empty($onlineStreams)) {
            do {
                //array_column($streams, 'user_id')
                $response = $this->getTwitchApi()->getUsersApi()->getUsers($this->getBearerToken(), $onlineStreams);
                $responseContent = json_decode($response->getBody()->getContents(), true);

                foreach ($responseContent["data"] as $user) {
                    $userId = $user["id"];
                    // Make the API call. A ResponseInterface object is returned.
                    $streams[$userId]["profile_image_url"] = $user["profile_image_url"];
                    $streams[$userId]["offline_image_url"] = $user["offline_image_url"];
                    $streams[$userId]["view_count"] = $user["view_count"];
                }
                $i++;
            } while ($i <= $limit);
        }

        foreach ($streams as $userId => $stream) {
            $response = $this->getTwitchApi()->getChannelsApi()->getChannelFollowers($this->getBearerToken(), (string) $userId);
            $responseContent = json_decode($response->getBody()->getContents(), true);
            $followerCount = $responseContent['total'];
            $stream['follower_count'] = $followerCount;
            $streams[$userId] = $stream;
        }
        Cache::put('twitchstreams', $streams);
    }
}