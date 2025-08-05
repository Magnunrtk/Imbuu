<?php

declare(strict_types=1);

namespace App\Utils;

use App\Models\House;
use Illuminate\Database\Eloquent\Model;

class HouseTransfer
{
    public static function canTransfer(Model $player, Model $house): array
    {
        $errorMessages = [];
        if(!config('houses.houseTransferEnable')) {
            $errorMessages[] = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'House transfers are currently disabled.',
            ];
        }

        if($player->level < 30){
            $errorMessages[] = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'Character '.$player->name.'. For transfer need a minimum level of 30.',
            ];
        }

        if(config('houses.needPremiumAccountToOwnHouse')) {
            if(!$player->account->isPremium()) {
                $errorMessages[] = [
                    'success' => false,
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => 'Houses can only be rented by characters on Premium accounts.',
                ];
            }
        }

        if($player->level < config('houses.minimumLevelToPlaceBid')) {
            $errorMessages[] = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => sprintf(
                    'The new owner needs to be at least level %s.',
                    config('houses.minimumLevelToPlaceBid')
                )
            ];
        }

        if(!is_null($player->house)) {
            $errorMessages[] = [
                'success' => true,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'This character owns a house already.'
            ];
        }

        if($player->town_id === 10) {
            $errorMessages[] = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'Characters based in Rookgaard are not allowed to rent houses.'
            ];
        }

        if($house->size > config('houses.freeAccountSize') && !$player->account->isPremium()) {
            $errorMessages[] = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => sprintf(
                    'This character cannot own houses over %s SQM',
                    config('houses.freeAccountSize')
                )
            ];
        }

        $onGoingAuction = House::whereHighestBidder($player->id)->first();
        if ($onGoingAuction) {
            $errorMessages[] = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'This character already holds the highest bid for another house. You may not transfer a house while auction.'
            ];
        }

        if (!empty($errorMessages)) {
            return $errorMessages[0];
        }
        return [];
    }
}
