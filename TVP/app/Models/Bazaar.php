<?php

/*
* @author Rickson Kauê
* @date Data de criação 10/01/2023
* @version 1.0
* @copyright (c) Ravenor
* @email ricksonkaue04@gmail.com
*/

declare(strict_types=1);

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\WebAccounts;

class Bazaar extends Model{
    public $user;
    public $accountId;

    public function __construct(){
        $this->user = Auth::user();
        $this->accountId = $this->user->id;
    }
    
    public function getCharacter(){

        $playerData = Player::where('account_id', $this->accountId)
        ->select('name')
        ->get();

        return $playerData;
    }
    
    public function getAccount(){

        $accountData = WebAccounts::where('account_id', $this->accountId)
        ->select('shop_coins', 'recovery_key')
        ->first();

        return $accountData;
    }

    public function history(){

        $bazaarHistory = DB::table('bazaar_hist')
            ->select('player_id', 'coins', 'date')
            ->get();

        $historyData = [];

        foreach ($bazaarHistory as $history) {

            $playerData = Player::where('id', $history->player_id)
                ->select('name')
                ->first();

            $historyData[] = [
                'player_name' => $playerData ? $playerData->name : null,
                'coins' => $history->coins,
                'date' => $history->date
            ];
        }

        usort($historyData, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });        

        return $historyData;
    }

    public function validOperation(){

        $erroMenssage = false;

        $characterName = request()->input('auction_character');
        $characterData = Player::where('name', $characterName)
        ->select('id', 'level')
        ->first();

        $accountCharacterNames = Player::where('account_id', $this->accountId)
        ->pluck('name')
        ->all();

        $accountData = WebAccounts::where('account_id', $this->accountId)
        ->select('shop_coins', 'recovery_key')
        ->first();

        $houseData = House::where('owner', $characterData->id)
        ->select('id')
        ->first();

        $guildOwner = Guild::where('ownerid', $characterData->id)
        ->select('ownerid')
        ->first();

        $guildInvited = GuildInvite::where('player_id', $characterData->id)
        ->select('player_id')
        ->first();

        $guildMember = GuildMembership::where('player_id', $characterData->id)
        ->select('player_id')
        ->first();

        $isOnline = PlayersOnline::where('player_id', $characterData->id)
        ->select('player_id')
        ->first();

        $hasSale = myaacBazaar::where('player_id', $characterData->id)->exists();
        $hasBan = AccountBan::where('account_id', $this->accountId)->exists();

        $allRequiriments = [
            'key' => ($accountData->recovery_key !== null) ? "yes" : "no",
            'level' => ($characterData->level >= 8) ? "yes" : "no",
            'house' => ($houseData && $houseData->id !== null) ? "no" : "yes",
            'guildGroup' => ($guildOwner !== null || $guildMember !== null) ? "no" : "yes",
            'guildApply' => ($guildInvited !== null) ? "no" : "yes",
            'online' => ($isOnline !== null) ? "no" : "yes",
            'ban' => ($hasBan !== false) ? "no" : "yes"
        ];
        
        $next_step = true;
        $currentRouteName = request()->route()->getName();

        if($currentRouteName != "account.bazaar.check_characters.post"){

            foreach ($allRequiriments as $value) { 
                if($value == "no") {
                    
                    $next_step = false;
                }
            }

        }
  
        if($currentRouteName != "account.bazaar.check_characters.post" && $currentRouteName != "account.bazaar.auction_characters.post"){

            $auctionDays = intval(request()->input('auctionDays'));
            $auctionPrice = intval(request()->input('auctionPrice'));         
            
            $inputNumbers = $auctionPrice > 0 ? true : false;

            $daysMax = $inputNumbers ? $auctionDays <= 28 : false;
            $coinsMax = $inputNumbers ? $auctionPrice <= 10000 : false;

        }else{

            $inputNumbers = null;
            $daysMax = null;
            $coinsMax = null;
        }

        $conditionsToErrors = [
            $characterName === null ? '#Bz01 Non-existent character.' : null,
            !in_array($characterName, $accountCharacterNames) ? '#Bz02 Character does not belong to the account.' : null,
            $next_step === false ? '#Bz03 Weighting does not meet the minimum requirements.' : null,
            $hasSale === true ? '#Bz04 Character is now for sale.' : null,
            $inputNumbers === false ? '#Bz05 Coin sales value cannot be zero or contain invalid characters. Or Days for sale cannot be zero or contain invalid characters.' : null,
            $daysMax === false ? "#Bz06 The days for sale cannot be longer than 28 days." : null,
            $coinsMax === false ? "#Bz07 The value of coins cannot exceed 10,000." : null
        ];

        $conditionsToErrors = array_filter($conditionsToErrors);
        $erroMenssage = $conditionsToErrors ? 'You cannot complete the operation error: "' . reset($conditionsToErrors) . '".' : null;

        $validInfo = [
            'characterData' => $characterData,
            'errorMenssage' => $erroMenssage,
            'playerData' => $allRequiriments
        ];
    
        return $validInfo;
    } 

    public function validateCharacter(){

        $validInfo = $this->validOperation();
        $errorMenssage = $validInfo['errorMenssage'];
        $playerData = $validInfo['playerData'];
        
        if($errorMenssage != false){

            return $errorMenssage;
        }

        return $playerData;
    }

    public function characterInfo(){

        $currentRouteName = Route::currentRouteName();

        if($currentRouteName == "account.bazaar.auction_confirm.post"){

            $rkBlock1 = request('rkBlock1');
            $rkBlock2 = request('rkBlock2');
            $rkBlock3 = request('rkBlock3');
            $rkBlock4 = request('rkBlock4');
    
            $cleanedBlock1 = preg_replace('/[^A-Z0-9]/', '', $rkBlock1);
            $cleanedBlock2 = preg_replace('/[^A-Z0-9]/', '', $rkBlock2);
            $cleanedBlock3 = preg_replace('/[^A-Z0-9]/', '', $rkBlock3);
            $cleanedBlock4 = preg_replace('/[^A-Z0-9]/', '', $rkBlock4);
    
            $joinedBlocks = implode('-', [$cleanedBlock1, $cleanedBlock2, $cleanedBlock3, $cleanedBlock4]);
    
            $recoveryKey = WebAccounts::where('account_id', $this->accountId)
                            ->where('recovery_key', $joinedBlocks)
                            ->first();
    
            if(!$recoveryKey){
    
                $erroMenssage = "Invalid Recovery Key.";
    
                return $erroMenssage;
            }
                
        }
        
        if($currentRouteName != "account.bazaar.statusAuction"){

            $validInfo = $this->validOperation();
            $characterData = $validInfo['characterData'];
            $errorMenssage = $validInfo['errorMenssage'];
            
            if($errorMenssage != false){
    
                return $errorMenssage;
            }
        }

        $auctionCharacterName = request()->input('auction_character');

        if($auctionCharacterName == null){

            $auctionCharacterName = request()->input('characterName');

            $_POST["auction_character"] = $auctionCharacterName;
        }

        $getCharacter = Player::where('name', $auctionCharacterName)
            ->select([
                'id',
                'level',
                'vocation',
                'sex',
                'health',
                'healthmax',
                'mana',
                'manamax',
                'cap',
                'soul',
                'blessings',
                'skill_axe',
                'skill_axe_tries',
                'skill_club',
                'skill_club_tries',
                'skill_dist',
                'skill_dist_tries',
                'skill_fishing',
                'skill_fishing_tries',
                'skill_fist',
                'skill_fist_tries',
                'maglevel',
                'skill_shielding',
                'skill_shielding_tries',
                'skill_sword',
                'skill_sword_tries',
                'created_at',
                'experience'
            ])
            ->first();
        

        $character_sex = ($getCharacter->sex == 0) ? 'Female' : 'Male';
        
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
        
        $character_voc = $vocationMapping[$getCharacter->vocation] ?? 'None';

        $characterData = [
            'level' => $getCharacter->level,
            'sex' => $character_sex,
            'vocation' => $character_voc,
            'health' => $getCharacter->health,
            'healthmax' => $getCharacter->healthmax,
            'mana' => $getCharacter->mana,
            'manamax' => $getCharacter->manamax,
            'cap' => $getCharacter->cap,
            'soul' => $getCharacter->soul,
            'blessings' => $getCharacter->blessings,
            'skill_axe' => $getCharacter->skill_axe,
            'skill_axe_tries' => $getCharacter->skill_axe_tries,
            'skill_club' => $getCharacter->skill_club,
            'skill_club_tries' => $getCharacter->skill_club_tries,
            'skill_dist' => $getCharacter->skill_dist,
            'skill_dist_tries' => $getCharacter->skill_dist_tries,
            'skill_fishing' => $getCharacter->skill_fishing,
            'skill_fishing_tries' => $getCharacter->skill_fishing_tries,
            'skill_fist' => $getCharacter->skill_fist,
            'skill_fist_tries' => $getCharacter->skill_fist_tries,
            'maglevel' => $getCharacter->maglevel,
            'skill_shielding' => $getCharacter->skill_shielding,
            'skill_shielding_tries' => $getCharacter->skill_shielding_tries,
            'skill_sword' => $getCharacter->skill_sword,
            'skill_sword_tries' => $getCharacter->skill_sword_tries,
            'created' => $getCharacter->created_at,
            'experience' => $getCharacter->experience
        ];

        return $characterData;
    }
    
    public function confirmAuction(){

        function gerarHashUnico() {
            return bin2hex(random_bytes(64));
        }

        do{

            $novoHash = gerarHashUnico(); 
            $existeHash = myaacBazaar::where('hash', $novoHash)->exists();
        }while($existeHash);

        $characterName = request()->input('auction_character');
        $characterData = Player::where('name', $characterName)
        ->select('id', 'level')
        ->first();

        Player::where('id', $characterData->id)
        ->update(['account_id' => 36706]);

        $dataAtual = new \DateTime(); 
        $directSale = intval(request("directSale"));

        if($directSale == 1){

            $statusSale = 4;
            $_POST["auctionPrice"] = 1;

        }else{

            $statusSale = 1;
        }

        myaacBazaar::create([
            'hash' => $novoHash,
            'account_old' => $this->accountId,
            'account_new' => 36706,
            'player_id' => $characterData->id,
            'price' => $_POST["auctionPrice"],
            'date_start' => $dataAtual->format('Y-m-d H:i:s'),
            'status' => $statusSale,
        ]);

        $sellValue = $_POST["auctionPrice"];
        
        WebAccounts::where('account_id', $this->accountId)
        ->update(['shop_coins' => DB::raw('shop_coins')]);

        $webhook = 'https://discord.com/api/webhooks/1214940819543298148/-bowUqsfwbeV53vRiqInTFCIYKWaDHJ4ugNyXHAg6PgmV4yu-qLCKg_XMtVZ_z3CLY-j';

        $hora = date('d/m/Y H:i:s');

$data = [

'content' =>("    
```[Ravenor Online] Bazaar-History

Id da transação: $novoHash

Id do vendedor:  $this->accountId

Valor da Venda: $sellValue

Data/Hora: $hora```")];

    $options = [

        'http' => [

            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data)

        ]

    ];

    $context = stream_context_create($options);
    $result = file_get_contents($webhook, false, $context);
    }

    public function playerAuctions(){

        $characterData = myaacBazaar::join('players', 'myaac_charbazaar.player_id', '=', 'players.id')
        ->where('myaac_charbazaar.account_old', $this->accountId)
        ->where(function ($query) {
            $query->where('myaac_charbazaar.date_end', '>', Carbon::now())
                  ->orWhereNull('myaac_charbazaar.date_end');
        })
        ->select('players.name', 'players.level', 'myaac_charbazaar.date_start', 'myaac_charbazaar.date_end', 'myaac_charbazaar.bid_price', 'myaac_charbazaar.price', 'myaac_charbazaar.hash', 'myaac_charbazaar.status')
        ->get();
    
        $shopCoins = WebAccounts::where('account_id', $this->accountId)
        ->select('shop_coins')
        ->first();

        $bidData = myaacBazaar::join('players', 'myaac_charbazaar.player_id', '=', 'players.id')
        ->where('myaac_charbazaar.bid_account', $this->accountId)
        ->where('myaac_charbazaar.bid_price', '>', 0)
        ->where('myaac_charbazaar.date_end', '>', now())
        ->select('players.name', 'myaac_charbazaar.date_start', 'myaac_charbazaar.date_end', 'myaac_charbazaar.bid_price', 'myaac_charbazaar.price', 'myaac_charbazaar.status')
        ->get();

        $actionData = myaacBazaar::join('players', 'myaac_charbazaar.player_id', '=', 'players.id')
        ->where('myaac_charbazaar.bid_account', $this->accountId)
        ->where('myaac_charbazaar.bid_price', '>', 0) 
        ->where(function ($query) {
            $query->where('myaac_charbazaar.date_end', '<', now()) 
                  ->orWhere('myaac_charbazaar.status', '=', 4); 
        })
        ->select('players.name', 'players.level', 'myaac_charbazaar.date_start', 'myaac_charbazaar.date_end', 'myaac_charbazaar.bid_price', 'myaac_charbazaar.price', 'myaac_charbazaar.status', 'myaac_charbazaar.hash')
        ->get();

        $sellerData = myaacBazaar::join('players', 'myaac_charbazaar.player_id', '=', 'players.id')
        ->where('myaac_charbazaar.account_old', $this->accountId)
        ->where('myaac_charbazaar.bid_price', '>', 0) 
        ->where(function ($query) {
            $query->where('myaac_charbazaar.status', '=', 4); 
        })
        ->select('players.name', 'players.level', 'myaac_charbazaar.date_start', 'myaac_charbazaar.date_end', 'myaac_charbazaar.bid_price', 'myaac_charbazaar.price', 'myaac_charbazaar.status', 'myaac_charbazaar.hash')
        ->get();

        if ($actionData->isEmpty()) {

            $actionData = myaacBazaar::join('players', 'myaac_charbazaar.player_id', '=', 'players.id')
            ->where('myaac_charbazaar.account_old', $this->accountId)
            ->where('myaac_charbazaar.date_end', '<', now())
            ->select('players.name', 'myaac_charbazaar.date_start', 'myaac_charbazaar.date_end', 'myaac_charbazaar.bid_price', 'myaac_charbazaar.price', 'myaac_charbazaar.status', 'myaac_charbazaar.hash')
            ->get();
        }
    
        return [
            'charactersData' => $characterData,
            'coins' => $shopCoins['shop_coins'],
            'bidData' => $bidData,
            'actionData' => $actionData,
            'sellerData' => $sellerData
        ];
    }

    public function getCurrentActions(){

        function decode_value($result) {
            $look_type = $result >> 16;
            $addons = $result & 0xFFFF;
            return [$look_type, $addons];
        }
        
        $accountId = $this->accountId;

        $charactersData = myaacBazaar::join('players', 'myaac_charbazaar.player_id', '=', 'players.id')
        ->where(function ($query) {
            $query->where('myaac_charbazaar.date_end', '>', now())
                  ->orWhereNull('myaac_charbazaar.date_end');
        })

        ->select(
            'players.id', 'players.name', 'players.level', 'players.vocation', 'players.sex',
            'players.looktype', 'players.lookaddons', 'players.lookhead', 'players.lookbody', 'players.looklegs', 'players.lookfeet',
            'myaac_charbazaar.date_start', 'myaac_charbazaar.date_end', 'myaac_charbazaar.bid_price', 'myaac_charbazaar.price', 'myaac_charbazaar.account_old','myaac_charbazaar.player_id', 'myaac_charbazaar.status'
        )
        ->get();

        $outifitsDataCollection = [];

        foreach ($charactersData as $key => $character) {
            $accountOld = $character->account_old;
            $playerId = $character->player_id;
            $hasBan = AccountBan::where('account_id', $accountOld)->exists();
        
            if($hasBan) {
                Player::where('id', $playerId)
                    ->update(['account_id' => $accountOld]);
        
                myaacBazaar::where('account_old', $accountOld)
                    ->delete();
                
                unset($charactersData[$key]);
            }

            $skinBits = DB::table('player_storage')
            ->where('player_id', $playerId)
            ->where('key', '>=', 10001001)
            ->pluck('value');

            $outifitsDataCollection[$playerId] = [];

            foreach ($skinBits as $value) {
                list($look_type, $addons) = decode_value($value);

               array_push($outifitsDataCollection[$playerId], [
                    'look_type' => $look_type,
                    'addons' => $addons
               ]);
            }
        }

        $dataSend = [

            'charactersData' => $charactersData,
            'accountId' => $accountId,
            'outifitsData' => $outifitsDataCollection
        ];
    
        return $dataSend;
    }

    public function directSaleCharacter(){

        $accountCharacterIds = Player::where('account_id', $this->accountId)
        ->pluck('id')
        ->all();

        $marketAccounts = myaacBazaar::where('account_old', $this->accountId)
        ->pluck('id')
        ->all();

        $valueAprove = count($marketAccounts) + count($accountCharacterIds);

        if($valueAprove < 6){

            $directSellCode = request("directCode");
            $cleanedDirectSellCode = preg_replace("/[^a-zA-Z0-9]/", "", $directSellCode);

            $accountCharacterId = myaacBazaar::where('hash', $cleanedDirectSellCode)
            ->select('player_id', 'price')
            ->first();

            $accountData = WebAccounts::where('account_id', $this->accountId)
            ->select('shop_coins')
            ->first();
    
            $charactersData = myaacBazaar::join('players', 'myaac_charbazaar.player_id', '=', 'players.id')
            ->where('player_id', '=', $accountCharacterId->player_id) 
            ->select(
                'players.id', 'players.name', 'players.level', 'players.vocation', 'players.sex',
                'players.looktype', 'players.lookaddons', 'players.lookhead', 'players.lookbody', 'players.looklegs', 'players.lookfeet',
                'myaac_charbazaar.date_start', 'myaac_charbazaar.date_end', 'myaac_charbazaar.bid_price', 'myaac_charbazaar.price'
            )
            ->get();

            $dataSend = [
    
                'charactersData' => $charactersData,
                'accountCharacterIds' => $accountCharacterIds,
                'accountData' => $accountData,
                'price' => $accountCharacterId->price
            ];
        
            return $dataSend;  
        }

        $erroMenssage = "Sorry, you cannot have more than six characters on your account.";
        return $erroMenssage;  
    }

    public function selectCurrentCharacter(){

        $accountCharacterIds = Player::where('account_id', $this->accountId)
        ->pluck('id')
        ->all();

        $marketAccounts = myaacBazaar::where('account_old', $this->accountId)
        ->pluck('id')
        ->all();

        $valueAprove = count($marketAccounts) + count($accountCharacterIds);

        if($valueAprove < 6){

            $selectCharacter = request('selectCharacter');

            $accountCharacterId = Player::where('name', $selectCharacter)
            ->select('id')
            ->first();
    
            $accountData = WebAccounts::where('account_id', $this->accountId)
            ->select('shop_coins')
            ->first();
    
            $charactersData = myaacBazaar::join('players', 'myaac_charbazaar.player_id', '=', 'players.id')
            ->where('player_id', '=', $accountCharacterId->id) 
            ->select(
                'players.id','players.name', 'players.level', 'players.vocation', 'players.sex',
                'players.looktype', 'players.lookaddons', 'players.lookhead', 'players.lookbody', 'players.looklegs', 'players.lookfeet',
                'myaac_charbazaar.date_start', 'myaac_charbazaar.date_end', 'myaac_charbazaar.bid_price', 'myaac_charbazaar.price'
            )
            ->get();
    
            $dataSend = [
    
                'charactersData' => $charactersData,
                'accountCharacterIds' => $accountCharacterIds,
                'accountData' => $accountData,
            ];
    
            return $dataSend;
        }

        $dataSend = 'Sorry, you cannot have more than six characters on your account.';

        return $dataSend;
    }

    public function bidValidation(){

        $shopCoins = WebAccounts::where('account_id', $this->accountId)
        ->select('shop_coins')
        ->first();

        $characterName = strval(request()->input('selectCharacter'));
        $bidPrice = intval(request()->input('maxBid'));


        $accountCharacterIds = Player::where('account_id', $this->accountId)
        ->pluck('id')
        ->all();

        $marketAccounts = myaacBazaar::where('account_old', $this->accountId)
        ->pluck('id')
        ->all();

        $limitCharacters = (count($marketAccounts) + count($accountCharacterIds) >= 6) ? true : false;

        $characterData = Player::where('name', $characterName)
        ->select('id', 'level')
        ->first();

        $hasSale = $characterData ? myaacBazaar::where('player_id', $characterData->id)->exists() : null;
        $realPrice = $characterData ? myaacBazaar::where('player_id', $characterData->id)->value('price') : null;
        $rightPrice = true;

        $characterData = Player::where('name', $characterName)
        ->select('id', 'level')
        ->first();

        $exists = myaacBazaar::where('player_id', $characterData->id)
        ->whereNotNull('bid_price')
        ->exists();

        $oldPrice = true;

        if($exists){

            $existingRecord = myaacBazaar::where('player_id', $characterData->id)->first();
            $existingBidPrice = $existingRecord->bid_price;
            $bidPrice = intval(request()->input('maxBid'));

            if($existingBidPrice >= $bidPrice){

                $oldPrice = false;
            }
        }

        $conditionsToErrors = [
            $characterData === null ? '#Bz01 Non-existent character.' : null,
            $hasSale === false ? '#Bz08 Character is not for sale.' : null,
            $rightPrice === (($realPrice == $bidPrice) || ($realPrice > $bidPrice)) ? '#Bz09 The value does not match.' : null,
            $limitCharacters === true ? '#Bz10 Character Limit Reached.' : null,
            $oldPrice === false ? '#Bz09 The value does not match.' : null
        ];

        $conditionsToErrors = array_filter($conditionsToErrors);
        $erroMenssage = $conditionsToErrors ? 'You cannot complete the operation error: "' . reset($conditionsToErrors) . '".' : null;

        if($shopCoins['shop_coins'] < $bidPrice){

            $erroMenssage = "You don't have enough coins to make this bid.";
        }

        if($erroMenssage != null){

            return $erroMenssage;
        }

        return null;
    }

    public function finishBid(){

        $erroMenssage = $this->bidValidation();

        if($erroMenssage != null){

            return $erroMenssage;
        }

        $dateNow = Carbon::now();
        $dateFuture = $dateNow->addHours(12);
        $formattedDate = $dateFuture->format('Y-m-d H:i:s');

        $bidPrice = intval(request()->input('maxBid'));
        $characterName = strval(request()->input('selectCharacter'));

        $characterData = Player::where('name', $characterName)
        ->select('id', 'level')
        ->first();

        $exists = myaacBazaar::where('player_id', $characterData->id)
        ->whereNotNull('bid_price')
        ->exists();

        if($exists){

            $existingRecord = myaacBazaar::where('player_id', $characterData->id)->first();
            $existingBidAccount = $existingRecord->bid_account;
            $existingBidPrice = $existingRecord->bid_price;

            WebAccounts::where('account_id', $existingBidAccount)
            ->update(['shop_coins' => DB::raw('shop_coins + ' . $existingBidPrice)]);

            myaacBazaar::where('player_id', $characterData->id)
            ->update([
                'bid_account' => $this->accountId,
                'bid_price' => $bidPrice,
                'date_end' => $formattedDate
            ]);
        
            WebAccounts::where('account_id', $this->accountId)
            ->update(['shop_coins' => DB::raw('shop_coins -' . $bidPrice)]);

        }else{

            $existingRecord = myaacBazaar::where('player_id', $characterData->id)->first();
            $playerGetLevel = player::where('id', $characterData->id)->first();
            $characterLevel = $playerGetLevel->level;
            $offerPrice = $existingRecord->price;

            if($existingRecord->status == 4){

                $tax = 75;

                if ($characterLevel >= 126) {
                    $tax = 250;
                } elseif ($characterLevel >= 101) {
                    $tax = 200;
                } elseif ($characterLevel >= 76) {
                    $tax = 150;
                } elseif ($characterLevel >= 51) {
                    $tax = 125;
                } elseif ($characterLevel >= 26) {
                    $tax = 100;
                }
    
                $finalValidPrice = $offerPrice +  $tax;
    
                if($bidPrice < $finalValidPrice){
    
                    $erroMenssage = "You cannot offer a price lower than the tax.";
                    return $erroMenssage;
                }
            }

            myaacBazaar::where('player_id', $characterData->id)
            ->update([
                'bid_account' => $this->accountId,
                'bid_price' => $bidPrice,
                'date_end' => $formattedDate
            ]);
        
            WebAccounts::where('account_id', $this->accountId)
            ->update(['shop_coins' => DB::raw('shop_coins -' . $bidPrice)]);
        }

        $webhook = 'https://discord.com/api/webhooks/1214965063581171722/aLh-1YD-_T3uQJHYAzUDqQkqcy6YR1XereRk5dUo5WezG6ea0qMlvdipg_S_lmVNs1Ny';

        $hora = date('d/m/Y H:i:s');

        $sellerId = $this->accountId;
        $characterId = $characterData->id;

$data = [

'content' =>("    
```[Ravenor Online] Bazaar-History

Id do Comprador: $sellerId

Id do Personagem: $characterId

Valor do Lançe: $bidPrice

Data/Hora: $hora```")];

    $options = [

        'http' => [

            'method' => 'POST',
            'header' => 'Content-Type: application/json',
            'content' => json_encode($data)

        ]

    ];

    $context = stream_context_create($options);
    $result = file_get_contents($webhook, false, $context);

        return 0;
    }

    public function completeOrder(){
        
        $hash = request()->input('hash');
        $hashExists = myaacBazaar::where('myaac_charbazaar.hash', $hash)->exists();
        $bazaarRecord = myaacBazaar::where('hash', $hash)->first();

        if ($bazaarRecord && is_null($bazaarRecord->bid_price)) {
            
            $accountOld = $bazaarRecord->account_old;
            $playerId = $bazaarRecord->player_id;

            Player::where('id', $playerId)->update(['account_id' => $accountOld]);
            $bazaarRecord->delete();

            return response()->json(['status' => 'success', 'message' => 'Account ID updated successfully.']);
        }

        if($hashExists == true){

            $bidData = myaacBazaar::where('myaac_charbazaar.hash', $hash)
            ->where(function($query) {
                $query->where('myaac_charbazaar.date_end', '<', now())
                      ->orWhere('myaac_charbazaar.status', 4);
            })
            ->select('myaac_charbazaar.date_start', 'myaac_charbazaar.date_end', 'myaac_charbazaar.bid_price', 'myaac_charbazaar.price', 'myaac_charbazaar.account_old', 'myaac_charbazaar.bid_account', 'myaac_charbazaar.player_id', 'myaac_charbazaar.status')
            ->get();

            if(!empty($bidData)){

                $oldAccount = $bidData[0]["account_old"];
                $playerId = $bidData[0]["player_id"];
                
                if($bidData[0]["bid_price"] > 0){

                    $newAccount = $bazaarRecord->bid_account;

                    Player::where('id', $playerId)
                    ->update(['account_id' => $newAccount]);

                    if($bidData[0]["status"] != 4){

                        $deduceTax = intval($bidData[0]["bid_price"] - ceil($bidData[0]["bid_price"] * 0.12));

                        WebAccounts::where('account_id', $oldAccount)
                        ->update(['shop_coins' => DB::raw("shop_coins + $deduceTax")]);

                        $dataToInsert[] = [
                            'account_old' => $bazaarRecord->account_old,
                            'account_new' => $bazaarRecord->bid_account,
                            'player_id' => $bazaarRecord->player_id,
                            'coins' => $bazaarRecord->bid_price, 
                            'hash' => $hash,
                            'method' => "Market",
                            'date' => Carbon::now() 
                        ];
                
                        DB::table('bazaar_hist')->insert($dataToInsert);    
                    }else{


                        $dataToInsert[] = [
                            'account_old' => $bazaarRecord->account_old,
                            'account_new' => $bazaarRecord->bid_account,
                            'player_id' => $bazaarRecord->player_id,
                            'coins' => $bazaarRecord->bid_price, 
                            'hash' => $hash,
                            'method' => "Direct Sell",
                            'date' => Carbon::now() 
                        ];
                
                        DB::table('bazaar_hist')->insert($dataToInsert);    
                    }
        
                    myaacBazaar::where('myaac_charbazaar.hash', $hash)
                    ->delete();

                    $response = "Payment made, and delivery of the char complete.";

                    $webhook = 'https://discord.com/api/webhooks/1214946702792859779/5JtrqESwzMGcRwFdrPsPzoC56yrFOvz0oACKj84zUsiy9eKKNPd21RIYIIuyDpV1AUa1';

                    $hora = date('d/m/Y H:i:s');

$data = [

        'content' =>("    
    ```[Ravenor Online] Bazaar-History

Id da transação: $hash

Id do vendedor: $oldAccount
            
Id do comprador: $newAccount

Valor da Venda: $deduceTax

Data/Hora: $hora```")];

                $options = [

                    'http' => [

                        'method' => 'POST',
                        'header' => 'Content-Type: application/json',
                        'content' => json_encode($data)

                    ]

                ];

                $context = stream_context_create($options);
                $result = file_get_contents($webhook, false, $context);

                }else{
        
                    Player::where('id', $playerId)
                    ->update(['account_id' => $oldAccount]);

                    $response = "Complete char return.";
                }
            }
        }else{

            $response = "Non-existent hash.";
        }

        return $response;
    }

    public function searchByHash($directSellCode)
    {

        $cleanedDirectSellCode = preg_replace("/[^a-zA-Z0-9]/", "", $directSellCode);
        $record = myaacBazaar::where('hash', $cleanedDirectSellCode)->first();

        if ($record) {
            if ($record->bid_price) {
                return 2;
            }else if($record->account_old == $this->accountId){
                return 3;
            } else {
                return 1; 
            }
        } else {
            return 0;
        }
    }
}

