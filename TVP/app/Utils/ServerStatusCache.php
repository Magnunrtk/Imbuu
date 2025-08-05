<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Support\Facades\Cache;

class ServerStatusCache
{
    private static string $cacheKey = 'server:status';

    public static function get(): string
    {
        if (!Cache::has(self::$cacheKey)) {
            self::cache();
        }
        return Cache::get(self::$cacheKey);
    }

    public static function set(Object $serverStatus): void
    {
        Cache::put(self::$cacheKey, $serverStatus);
    }

    private static function setOffline(): void
    {
        $serverInformation = new \stdClass;
        $serverInformation->status = false;
        Cache::put(
            self::$cacheKey,
            json_encode($serverInformation),
        );
    }

    private static function setOnline(string $data): void
    {
        $xmlObject = simplexml_load_string($data);
        $convertXMLtoJSON = json_encode($xmlObject);
        $responseConvert = json_decode($convertXMLtoJSON, true);
        $serverInformation = new \stdClass;
        $serverInformation->status = true;
        $serverInformation->players = $responseConvert['players']['@attributes'];
        $serverInformation->uptime = $responseConvert['serverinfo']['@attributes']['uptime'];
        $serverInformation->npcs = $responseConvert['npcs']['@attributes']['total'];
        $serverInformation->monsters = $responseConvert['monsters']['@attributes']['total'];
        $serverInformation->lastUpdate = time();
        Cache::put(
            self::$cacheKey,
            json_encode($serverInformation),
        );
    }

    private static function status(): string
    {
        $answer = '';
        $socket = @fsockopen(config('server.serverStatusIP'), 7171, $errno, $errstr, 1);
        if ($socket) {
            stream_set_timeout($socket, 5);
            fwrite($socket, chr(6) . chr(0) . chr(255) . chr(255) . 'info');
            while (!feof($socket)) {
                $answer .= fgets($socket, 128);
            }
            fclose($socket);
        }
        return $answer;
    }

    public static function cache(?int $tries = 1): void
    {
        $serverInfo = self::status();
        if(!empty($serverInfo)) {
            self::setOnline($serverInfo);
        } else {
            $tries = $tries + 1;
            if($tries >= 5) {
                self::setOffline();
            } else {
                sleep(1);
                self::cache($tries);
            }
        }
    }

    public static function serverInfo()
    {
        if (!Cache::has(self::$cacheKey)) {
            self::cache();
        }
        return json_decode(Cache::get(self::$cacheKey));
    }
}
