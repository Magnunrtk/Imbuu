<?php

declare(strict_types=1);

namespace App\Utils;

class World
{
    public static function getWorldNameByWorldId(int $worldId): string
    {
        if(!empty(config('multi_world.worlds')[$worldId])) {
            return config('multi_world.worlds')[$worldId]['name'];
        }
        return 'World not found';
    }

    public static function getWorldByWorldId(int $worldId): array
    {
        if(!empty(config('multi_world.worlds')[$worldId])) {
            return config('multi_world.worlds')[$worldId];
        }
        return [];
    }

    public static function getWorldExists(int $worldId): bool
    {
        if(!empty(config('multi_world.worlds')[$worldId])) {
            return true;
        }
        return false;
    }

    public static function getWorldBySubdomain(): array|null
    {
        $subdomain = request()->route('subdomain');
        if(!empty(config('multi_world.worlds')[$subdomain])) {
            return config('multi_world.worlds')[$subdomain];
        }
        return [];
    }

    public static function getCurrentWorld(): array
    {
        if(config('multi_world.worldsBySubdomain')) {
            $subdomain = request()->route('subdomain');
            $worldKey = array_search($subdomain, array_column(config('multi_world.worlds'), 'slug'));
            return config('multi_world.worlds')[$worldKey];
        }
        return config('multi_world.worlds')[0];
    }
}
