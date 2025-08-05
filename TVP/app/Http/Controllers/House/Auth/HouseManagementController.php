<?php

declare(strict_types=1);

namespace App\Http\Controllers\House\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\HouseManagementRequest;
use App\Models\Player;
use App\Models\WebHouseMoveOut;
use App\Models\WebHouseTransfer;
use App\Utils\HouseTransfer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class HouseManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function moveOut(Request $request): RedirectResponse|View
    {
        $house = $request->house;
        if(!$house->ownerOnLoggedInAccount() || $house->moveOut) {
            return redirect()->route('landing');
        }
        return view('community.view.house.manage.move-out', compact('house'));
    }

    public function moveOutAction(HouseManagementRequest $request): RedirectResponse|View
    {
        $house = $request->house;
        if(!$house->ownerOnLoggedInAccount() || $house->moveOut) {
            return redirect()->route('landing');
        }
        $serverSave = explode(':', config('server.serverSaveTime'));
        $date = Carbon::createFromFormat('d/m/Y', $request->input('date'))
            ->setHour((int) $serverSave[0])
            ->setMinute((int) $serverSave[1]);
        if ($date > Carbon::now()->addDays(30)) {
            return Redirect::route('community.view.house.index', $house->id)->with(
                'error',
                'The move out date cannot be more than 30 days.'
            );
        }
        $moveOut = WebHouseMoveOut::create([
            'house_id' => $house->id,
            'date' => $date,
            'time' => $date->timestamp,
        ]);
        return view('community.view.house.manage.move-out-submitted', compact('house', 'moveOut'));
    }

    public function keepHouse(Request $request): RedirectResponse|View
    {
        $house = $request->house;
        $houseTransfer = $house->moveOut->transfer;
        if(!$house->ownerOnLoggedInAccount() || !$house->moveOut || $houseTransfer && $houseTransfer->accepted) {
            return redirect()->route('landing');
        }
        return view('community.view.house.manage.cancel', compact('house'));
    }

    public function keepHouseAction(HouseManagementRequest $request): RedirectResponse
    {
        $house = $request->house;
        $houseTransfer = $house->moveOut->transfer;
        if(!$house->ownerOnLoggedInAccount() || !$house->moveOut || $houseTransfer && $houseTransfer->accepted) {
            return redirect()->route('landing');
        }
        WebHouseMoveOut::whereHouseId($house->id)?->delete();
        return Redirect::route('community.view.house.index', $house->id)->with(
            'success',
            'Your character will <b>not move out</b> and keep the house.'
        );
    }

    public function transfer(Request $request): RedirectResponse|View
    {
        $house = $request->house;
        if(!$house->ownerOnLoggedInAccount() || $house->moveOut) {
            return redirect()->route('landing');
        }
        return view('community.view.house.manage.transfer', compact('house'));
    }

    public function transferAction(HouseManagementRequest $request): RedirectResponse|View
    {
        $house = $request->house;
        if(!$house->ownerOnLoggedInAccount() || $house->moveOut) {
            return redirect()->route('landing');
        }
        $newOwner = Player::whereName($request->input('character'))->first();
        $canTransfer = HouseTransfer::canTransfer($newOwner, $house);
        if(!empty($canTransfer)) {
            return Redirect::back()
                ->with(
                    'error',
                    $canTransfer['message']
                );
        }
        $serverSave = explode(':', config('server.serverSaveTime'));
        $date = Carbon::createFromFormat('d/m/Y', $request->input('date'))
            ->setHour((int) $serverSave[0])
            ->setMinute((int) $serverSave[1]);
        if ($date > Carbon::now()->addDays(30)) {
            return Redirect::route('community.view.house.index', $house->id)->with(
                'error',
                'The transfer date cannot be more than 30 days.'
            );
        }
        $moveOut = WebHouseMoveOut::create([
            'house_id' => $house->id,
            'date' => $date,
            'time' => $date->timestamp
        ]);
        WebHouseTransfer::create([
            'move_out_id' => $moveOut->id,
            'new_owner' => $newOwner->id,
            'price' => (int) $request->input('gold'),
        ]);
        return view('community.view.house.manage.transfer-submitted', compact('house', 'moveOut'));
    }

    public function accept(Request $request): RedirectResponse|View
    {
        $house = $request->house;
        $houseTransfer = $house->moveOut->transfer;
        if ((!$house->ownerOnLoggedInAccount() && $houseTransfer->player->account_id !== Auth::user()->id)
            || !$house->moveOut
            || !$houseTransfer
            || $houseTransfer->accepted
        ) {
            return redirect()->route('landing');
        }
        return view('community.view.house.manage.accept-transfer', compact('house'));
    }

    public function acceptAction(HouseManagementRequest $request): RedirectResponse
    {
        $house = $request->house;
        $houseTransfer = $house->moveOut->transfer;
        if ((!$house->ownerOnLoggedInAccount() && $houseTransfer->player->account_id !== Auth::user()->id)
            || !$house->moveOut
            || !$houseTransfer
            || $houseTransfer->accepted
        ) {
            return redirect()->route('landing');
        }
        switch ((int) $request->input('action')) {
            case 1:
                $canTransfer = HouseTransfer::canTransfer($houseTransfer->player, $house);
                if(!empty($canTransfer)) {
                    return Redirect::back()
                        ->with(
                            'error',
                            $canTransfer['message']
                        );
                }
                $houseTransfer->accepted = true;
                $houseTransfer->save();
                $message = 'You have accepted the transfer of the house.';
                break;
            case 2:
            default:
                $house->moveOut->delete();
                $message = 'You have declined the transfer of the house.';
                break;
        }
        return Redirect::route('community.view.house.index', $house->id)->with(
            'success',
            $message
        );
    }
}
