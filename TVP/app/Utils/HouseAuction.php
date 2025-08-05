<?php

declare(strict_types=1);

namespace App\Utils;

use App\Models\House;
use App\Models\WebHouseTransfer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HouseAuction
{
    public static function canBid(Model $player, Model $house): array
    {
        $errorMessages = [];

        if(!config('houses.houseAuctionEnable')) {
            $errorMessages[] = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'House auctions are currently disabled.',
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
                    'You need to be at least level %s in order to place a bid.',
                    config('houses.minimumLevelToPlaceBid')
                )
            ];
        }

        if(!is_null($player->house)) {
            $errorMessages[] = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'This character owns a house already.'
            ];
        }

        if($player->online) {
            $errorMessages[] = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'You may not raise bids while you are online. Please log out first.'
            ];
        }

        if($house->owner !== 0) {
            $errorMessages[] = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'This house is not for auction.'
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

        $onGoingAuction = House::whereIn('highest_bidder', Auth::user()->characters->pluck('id')->toArray())->first();
        if ($onGoingAuction && $onGoingAuction->id !== $house->id) {
            $errorMessages[] = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'A character of your account already holds the highest bid for another house. You may only bid for one house at the same time.'
            ];
        }

        if (WebHouseTransfer::whereNewOwner($player->id)->whereAccepted(true)->exists()) {
            $errorMessages[] = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'There is an ongoing house transfer for this character.'
            ];
        }

        if($house->bid_end !== 0 && Carbon::createFromTimestamp($house->bid_end)->toDateTimeString() <= Carbon::now()) {
            $errorMessages[] = [
                'success' => false,
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'The auction for this house ended already.'
            ];
        }

        if (!empty($errorMessages)) {
            return $errorMessages[0];
        }
        return [];
    }
}
