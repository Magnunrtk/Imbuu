<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Support\Facades\Http;

class TibiaData
{
    public static function characterExists(string $name): bool
    {
        $url = 'https://api.tibiadata.com/v4/character/' . urlencode($name);
        $response = Http::get($url);
        if ($response->successful()) {
            $responseData = json_decode($response->body(), true);
            if (isset($responseData['character']['character']['name']) && !empty($responseData['character']['character']['name'])) {
                return true;
            }
        }
        return false;
    }
}
