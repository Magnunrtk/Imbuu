<?php

declare(strict_types=1);

namespace App\Utils;

class Town
{
    public static function getTownByName(string $name): array
    {
        try {
            $town = array_search($name, array_column(config('towns.town_ids'), 'slug'));
            return config('towns.town_ids')[$town];
        } catch (\Exception $e) {
            report($e);
        }
    }

    public static function getTownById(string $townId): array
    {
        try {
            $town = array_search($townId, array_column(config('towns.town_ids'), 'id'));
            return config('towns.town_ids')[$town];
        } catch (\Exception $e) {
            report($e);
        }
    }
}
