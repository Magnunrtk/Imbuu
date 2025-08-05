<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class MediviaCoinsApiController extends Controller
{
    public function info(string $id): JsonResponse
    {
        $mediviaCoinsConfig = config('shop.payment_options')['medivia_coins'];
        if (!isset($mediviaCoinsConfig['server_list']) || !isset($mediviaCoinsConfig['characters'])) {
            return response()->json(['success' => false]);
        }

        $serverList = $mediviaCoinsConfig['server_list'];
        $characters = $mediviaCoinsConfig['characters'];
        if (!isset($serverList[(int) $id])) {
            return response()->json(['success' => false]);
        }

        $selectedServer = $serverList[(int) $id];
        $serverInfo = null;
        foreach ($characters as $character) {
            if ($character['server'] === $selectedServer) {
                $serverInfo = $character;
                break;
            }
        }
        if ($serverInfo === null) {
            return response()->json(['success' => false]);
        }

        return response()->json([
            'success' => true,
            'name' => $serverInfo['server'] ?? null,
            'city' => $serverInfo['city'] ?? null,
            'receiver_name' => $serverInfo['receiver_name'] ?? null,
        ]);
    }
}