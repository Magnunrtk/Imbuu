<?php
/*
* @author Rickson Kauê
* @date Data de criação 10/01/2023
* @version 1.0
* @copyright (c) Ravenor
* @email ricksonkaue04@gmail.com
*/

declare(strict_types=1);

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Utils\EasyFormaters;
use App\Models\Bazaar;

class BazaarController extends Controller{
    public function __construct(){

        $this->middleware('auth');
    }

    public function sell_characters($check): View {

        $characters = new Bazaar();
        $formaters = new EasyFormaters();
    
        if ($check == "sell_characters"){

            $characterData = $characters->getCharacter();
            $characters_names = $characterData->pluck('name')->toArray();
            $charQuantity = count(array_unique($characters_names));    

            return view('bazaar.sell.index', [
                'formaters' => $formaters,
                'number_characters' => $charQuantity,
                'characters_names' => $characters_names,
            ]);
        }else if($check == "check_characters") {

            $playerData = $characters->validateCharacter();

            if(is_string($playerData)) {

                return view('bazaar.sell.erro', [

                    'formaters' => $formaters,
                    'erro' => $playerData
                ]);
            }

            $img_icons = [
                'yes' => '/assets/tibiarl/images/premiumfeatures/icon_yes.png',
                'no' => '/assets/tibiarl/images/premiumfeatures/icon_no.png',
            ];

            return view('bazaar.sell.check', [
                'formaters' => $formaters,
                'playerData' => $playerData,
                'icons' => $img_icons
            ]);

        }else if($check == "auction_characters"){

            $playerData = $characters->characterInfo();

            if(is_string($playerData)) {

                return view('bazaar.sell.erro', [

                    'formaters' => $formaters,
                    'erro' => $playerData
                ]);
            }

            return view('bazaar.sell.auction', [
                'formaters' => $formaters,
                'playerData' => $playerData
            ]);

        }else{

            $playerData = $characters->characterInfo();
            $playerAccount = $characters->getAccount();

            if(is_string($playerData)) {

                return view('bazaar.sell.erro', [

                    'formaters' => $formaters,
                    'erro' => $playerData
                ]);
            }

            return view('bazaar.sell.confirm', [
                'formaters' => $formaters,
                'playerData' => $playerData,
                'accountData' => $playerAccount
            ]);
        }
    }
    
    public function auctions(): View|RedirectResponse {

        $currentRouteName = request()->route()->getName();
        $characters = new Bazaar();
        $formaters = new EasyFormaters();
    
        if($currentRouteName == "account.bazaar.myAuctions.post") {
        
            $playerData = $characters->characterInfo();
    
            if(is_string($playerData)) {
                return view('bazaar.sell.erro', [
                    'formaters' => $formaters,
                    'erro' => $playerData
                ]);
            }

            $characters->confirmAuction();
            return redirect()->route('account.bazaar.myAuctions');
        }else{

            $playerData = $characters->playerAuctions();
            return view('bazaar.auctions', [
                
                'playerData' => $playerData,
                'formaters' => $formaters
            ]);
        }
    }

    public function currentAuctions(): View|RedirectResponse{
        
        $cssFilePath = '/assets/css/drk01.css';
        echo '<link rel="stylesheet" href="' . $cssFilePath . '">';

        $currentRouteName = request()->route()->getName();

        $characters = new Bazaar();
        $formaters = new EasyFormaters();

        $vocationMapping = [
            0 => 'Rookguard',
            1 => 'Sorcerer',
            2 => 'Druid',
            3 => 'Paladin',
            4 => 'Knight',
            5 => 'Master Sorcerer',
            6 => 'Elder Druid',
            7 => 'Royal Paladin',
            8 => 'Elite Knight',
        ];

        if($currentRouteName == "account.bazaar.currentAuctions"){

            
            $charactersData = $characters->getCurrentActions();
        
            return view(
                
                'bazaar.buy.index', [
                
                'charactersData' => $charactersData['charactersData'],
                'vocations' => $vocationMapping,
                'accountId' => $charactersData['accountId'],
                'formaters' => $formaters,
                'outifitsData' => $charactersData['outifitsData']
            ]);

        }else if($currentRouteName == "account.bazaar.bidAuction"){
            

            $actionCode = intval(request("action"));
            if($actionCode == 4){
                
                $directSellCode = request("directCode");
                $cleanedDirectSellCode = preg_replace("/[^a-zA-Z0-9]/", "", $directSellCode);
                $hasDirectOffer = $characters->searchByHash($cleanedDirectSellCode);

                if($hasDirectOffer == 1){

                    $charactersData = $characters->directSaleCharacter();

                    if(gettype($charactersData) == "string"){

                               
                        return view('bazaar.sell.erro', [
            
                            'formaters' => $formaters,
                            'erro' => $charactersData
                        ]);
                    }

                    return view(
                
                        'bazaar.buy.confirm', [
        
                            'charactersData' => $charactersData['charactersData'],
                            'vocations' => $vocationMapping,
                            'playerIds' => $charactersData['accountCharacterIds'],
                            'shopCoins' => $charactersData['accountData']->shop_coins,
                            'price' => $charactersData['price'],
                            'actionCode' => 4
                    ]);

                }elseif($hasDirectOffer == 2){
       
                    return view('bazaar.sell.erro', [
        
                        'formaters' => $formaters,
                        'erro' => 'This character already has an offer.'
                    ]);

                }else if($hasDirectOffer == 3){

                    return view('bazaar.sell.erro', [
        
                        'formaters' => $formaters,
                        'erro' => 'This character belongs to you.'
                    ]);

                }else{

                    return view('bazaar.sell.erro', [
        
                        'formaters' => $formaters,
                        'erro' => 'No corresponding offer.'
                    ]);
                }
            }

            $playerData = $characters->bidValidation();

            if(is_string($playerData)) {
    
                return view('bazaar.sell.erro', [
    
                    'formaters' => $formaters,
                    'erro' => $playerData
                ]);
            }

            $charactersData = $characters->selectCurrentCharacter();

            if(is_string($charactersData)) {
    
                return view('bazaar.sell.erro', [
    
                    'formaters' => $formaters,
                    'erro' => $charactersData
                ]);
            }

            return view(
                
                'bazaar.buy.confirm', [

                    'charactersData' => $charactersData['charactersData'],
                    'vocations' => $vocationMapping,
                    'playerIds' => $charactersData['accountCharacterIds'],
                    'shopCoins' => $charactersData['accountData']->shop_coins,
                    'actionCode' => 1
            ]);

        }else if($currentRouteName == "account.bazaar.statusAuction"){

            $playerData = $characters->characterInfo();

            if(is_string($playerData)) {

                return view('bazaar.sell.erro', [

                    'formaters' => $formaters,
                    'erro' => $playerData
                ]);
            }

            return view(
                
                'bazaar.buy.status', [

                    'playerData' => $playerData,
            ]);

        }else if($currentRouteName == "account.bazaar.finishBid"){

            $playerData = $characters->finishBid();

            if(is_string($playerData)) {
    
                return view('bazaar.sell.erro', [
    
                    'formaters' => $formaters,
                    'erro' => $playerData
                ]);
            }

            return redirect()->route('account.bazaar.myAuctions');
        }

        return redirect()->route('account.bazaar.myAuctions');
    }

    public function auction_history(): View{

        $characters = new Bazaar();
        $history = $characters->history();

        return view('bazaar.auctions_history', ['history' => $history]);
    }

    public function completeOrders(){

        $bazaar = new Bazaar();
        $response = $bazaar->completeOrder();

        return response()->json(['message' =>  $response]);
    }
}