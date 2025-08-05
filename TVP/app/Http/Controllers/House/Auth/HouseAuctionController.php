<?php

declare(strict_types=1);

namespace App\Http\Controllers\House\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\HouseAuctionRequest;
use App\Models\Player;
use App\Utils\FormatNumber;
use App\Utils\HouseAuction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class HouseAuctionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index(Request $request): RedirectResponse|View
    {
        $house = $request->house;
        if($house->owner !== 0 || !config('houses.houseAuctionEnable')) {
            return redirect()->route('landing');
        }
        return view('community.view.house.auction.index', compact('house'));
    }

    public function placeBid(HouseAuctionRequest $request): RedirectResponse
    {
        $house = $request->house;
        $player = Player::whereName($request->input('character'))->first();
        $cannotBid = HouseAuction::canBid($player, $house);

        if(!empty($cannotBid)) {

            return redirect(route('community.view.house.auction.index', $house->id))
                ->with(
                    'error',
                    $cannotBid['message']
                );

        }

        $bid = (int) $request->input('bid');
        
        if ($player->id === $house->highest_bidder) {

            if ($bid <= $house->last_bid) {
                return Redirect::back()
                    ->with(
                        'error',
                        'Your bid limit must be higher than the current highest bid.'
                    );
            }

            $house->bid = $bid;
            $house->save();

            return Redirect::back()
                ->with(
                    'success',
                    sprintf('Your limit for the bid has been set to %s gold.', FormatNumber::properConvert($bid))
                );
        }

        if($bid <= $house->last_bid) {

            return Redirect::back()

                ->with(
                    'error',
                    sprintf(
                        'The current bid is at %s. You need to bid at least %s.',
                        $house->last_bid,
                        $house->last_bid + 1
                    )
                );
        }

        if($bid <= $house->bid) {

            $house->last_bid = $bid;
            $house->save();

            return Redirect::back()
                ->with(
                    'success',
                    sprintf(
                        'Your bid has been placed but you have been outbid by %s.',
                        $house->highestBidderPlayer->name,
                    )
                );

        }

        if($house->bid === 0) {

            $serverSave = explode(':', config('server.serverSaveTime'));
            $endAuction = Carbon::now()->addDays(config('houses.houseAuctionTimeInDays'))
                ->setHour((int) $serverSave[0])
                ->setMinute((int) $serverSave[1])
                ->setSecond(0)
                ->timestamp;
            $house->bid_end = $endAuction;
            $house->bid = $bid;
            $house->highest_bidder = $player->id;
            $house->last_bid = 0;
            $house->save();

            return Redirect::back()
                ->with(
                    'success',
                    sprintf(
                        'You have submitted the first bid for this house. Your limit is %s gold.',
                        $house->bid
                    )
                );
        }

        $house->last_bid = $house->bid + 1;
        $house->bid = $bid;
        $house->highest_bidder = $player->id;
        $house->save();

        return Redirect::back()
            ->with(
                'success',
                'Congratulations! You are the highest bidder now.'
            );
    }
}
