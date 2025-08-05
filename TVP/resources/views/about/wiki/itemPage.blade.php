@extends('template.layout')
@section('title', 'Items')
@section('submenuItem', 'items')
@section('content')

@php 
    
include "./npcs.php"; 
include "./items.php"; 
include "./monsterXml.php"; 
include "./itemsFunctions.php";  

$item = $item ?? '';  
$item = urldecode($item);

$runas = [

    "adana mort" => ["Animate Dead Rune", "Support"],
    "adana pox" => ["Cure Poison Rune", "Support"],
    "adevo mas vis" => ["Energy Bomb Rune", "Support"],
    "adori mas frigo" => ["Avalanche Rune", "Support"],
    "uteta res sac" => ["Avatar of Light", "Support"],
    "uteta res dru" => ["Avatar of Nature", "Support"],
    "uteta res eq" => ["Avatar of Steel", "Support"],
    "uteta res ven" => ["Avatar of Storm", "Support"],
    "exori" => ["Berserk", "Attack"],
    "utito tempo" => ["Blood Rage", "Support"],
    "exura infir ico" => ["Bruise Bane", "Healing"],
    "exori ico" => ["Brutal Strike", "Attack"],
    "exori infir vis" => ["Buzz", "Attack"],
    "exana ina" => ["Cancel Invisibility", "Support"],
    "exana vita" => ["Cancel Magic Shield", "Support"],
    "exeta res" => ["Challenge", "Support"],
    "adevo ina" => ["Chameleon Rune", "Support"],
    "utani tempo hur" => ["Charge", "Support"],
    "exevo infir frigo hur" => ["Chill Out", "Attack"],
    "exeta amp res" => ["Chivalrous Challenge", "Support"],
    "exevo con" => ["Conjure Arrow", "Support"],
    "exevo con flam" => ["Conjure Explosive Arrow", "Support"],
    "exevo gran mort" => ["Conjure Wand of Darkness", "Support"],
    "adeta sio" => ["Convince Creature Rune", "Support"],
    "utevo res ina" => ["Creature Illusion", "Support"],
    "exana kor" => ["Cure Bleeding", "Healing"],
    "exana flam" => ["Cure Burning", "Healing"],
    "exana mort" => ["Cure Curse", "Healing"],
    "exana vis" => ["Cure Electrification", "Healing"],
    "exana pox" => ["Cure Poison", "Healing"],
    "adana pox" => ["Cure Poison Rune", "Support"],
    "utori mort" => ["Curse", "Attack"],
    "exori mort" => ["Death Strike", "Attack"],
    "adito grav" => ["Destroy Field Rune", "Support"],
    "adito tera" => ["Disintegrate Rune", "Support"],
    "exevo mas san" => ["Divine Caldera", "Attack"],
    "exana amp res" => ["Divine Dazzle", "Support"],
    "utevo grav san" => ["Divine Empowerment", "Support"],
    "exevo tempo mas san" => ["Divine Grenade", "Attack"],
    "exura san" => ["Divine Healing", "Healing"],
    "exori san" => ["Divine Missile", "Attack"],
    "utori vis" => ["Electrify", "Attack"],
    "utori mas sio" => ["Enchant Party", "Support"],
    "exeta con" => ["Enchant Spear", "Support"],
    "exevo vis lux" => ["Energy Beam", "Attack"],
    "adevo mas vis" => ["Energy Bomb Rune", "Support"],
    "adevo grav vis" => ["Energy Field Rune", "Support"],
    "exori vis" => ["Energy Strike", "Attack"],
    "adevo mas grav vis" => ["Energy Wall Rune", "Support"],
    "exevo vis hur" => ["Energy Wave", "Attack"],
    "utori pox" => ["Envenom", "Attack"],
    "exevo gran mas frigo" => ["Eternal Winter", "Attack"],
    "exori con" => ["Ethereal Spear", "Attack"],
    "exori amp kor" => ["Executioner's Throw", "Attack"],
    "adevo mas hur" => ["Explosion Rune", "Support"],
    "exori moe" => ["Expose Weakness", "Support"],
    "exura med ico" => ["Fair Wound Cleansing", "Healing"],
    "exori gran" => ["Fierce Berserk", "Attack"],
    "exiva moe res" => ["Find Fiend", "Support"],
    "exiva" => ["Find Person", "Support"],
    "adevo mas flam" => ["Fire Bomb Rune", "Support"],
    "adevo grav flam" => ["Fire Field Rune", "Support"],
    "adevo mas grav flam" => ["Fire Wall Rune", "Support"],
    "exevo flam hur" => ["Fire Wave", "Attack"],
    "adori flam" => ["Fireball Rune", "Support"],
    "exori flam" => ["Flame Strike", "Attack"],
    "exevo pan" => ["Food", "Support"],
    "exori min" => ["Front Sweep", "Attack"],
    "exevo max mort" => ["Great Death Beam", "Attack"],
    "exevo gran vis lux" => ["Great Energy Beam", "Attack"],
    "exevo gran flam hur" => ["Great Fire Wave", "Attack"],
    "adori gran" => ["Heavy Magic Missile Rune", "Support"],
    "exevo gran" => ["Great Fire", "Attack"],
    "utevo gran lux" => ["Great Light", "Support"],
    "exori mas" => ["Groundshaker", "Attack"],
    "utani hur" => ["Haste", "Support"],
    "exura sio" => ["Heal Friend", "Healing"],
    "utura mas sio" => ["Heal Party", "Support"],
    "adori vis" => ["Heavy Magic Missile Rune", "Support"],
    "exevo gran mas flam" => ["Hell's Core", "Attack"],
    "utori san" => ["Holy Flash", "Attack"],
    "adori san" => ["Holy Missile Rune", "Support"],
    "exevo ulus frigo" => ["Ice Burst", "Attack"],
    "exori frigo" => ["Ice Strike", "Attack"],
    "exevo frigo hur" => ["Ice Wave", "Attack"],
    "adori" => ["Light Magic Missile Rune", "Support"],
    "utori flam" => ["Ignite", "Attack"],
    "utori kor" => ["Inflict Wound", "Attack"],
    "exura gran" => ["Intense Healing", "Healing"],
    "adura gran" => ["Intense Healing Rune", "Support"],
    "utura gran" => ["Intense Recovery", "Healing"],
    "exura gran ico" => ["Intense Wound Cleansing", "Healing"],
    "utana vid" => ["Invisible", "Support"],
    "exori infir con" => ["Lesser Ethereal Spear", "Attack"],
    "exori infir min" => ["Lesser Front Sweep", "Attack"],
    "exani hur" => ["Levitate", "Support"],
    "utevo lux" => ["Light", "Support"],
    "exura" => ["Light Healing", "Healing"],
    "adori min vis" => ["Light Magic Missile Rune", "Support"],
    "exori amp vis" => ["Lightning", "Attack"],
    "exura infir" => ["Magic Patch", "Healing"],
    "exani tera" => ["Magic Rope", "Support"],
    "utamo vita" => ["Magic Shield", "Support"],
    "adevo grav tera" => ["Magic Wall Rune", "Support"],
    "exura gran mas res" => ["Mass Healing", "Healing"],
    "exevo ulus tera" => ["Mud Attack", "Attack"],
    "exura gran sio" => ["Nature's Embrace", "Healing"],
    "adana ani" => ["Paralyse Rune", "Support"],
    "exori moe ico" => ["Physical Strike", "Attack"],
    "adevo res pox" => ["Envenom Rune", "Support"],
    "adevo grav pox" => ["Poison Field Rune", "Support"],
    "adevo mas grav pox" => ["Poison Wall Rune", "Support"],
    "adevo mas pox" => ["Poison Bomb Rune ", "Support"],
    "utamo mas sio" => ["Protect Party", "Support"],
    "utamo tempo" => ["Protector", "Support"],
    "exevo gran mas vis" => ["Rage of the Skies", "Attack"],
    "utura" => ["Recovery", "Healing"],
    "exura max vita" => ["Restoration", "Healing"],
    "exura gran san" => ["Salvation", "Healing"],
    "exori kor" => ["Sap Strength", "Support"],
    "exevo infir flam hur" => ["Scorch", "Attack"],
    "utito tempo san" => ["Sharpshooter", "Support"],
    "adevo res flam" => ["Soulfire Rune", "Support"],
    "adori tera" => ["Stalagmite Rune", "Support"],
    "exura si" => ["Support Healing", "Healing"],
    "adana sio" => ["Support Rune", "Support"],
    "adori vita vis" => ["Sudden Death Rune", "Attack"],
    "adevo grav vita" => ["Wild Growth Rune", "Attack"],
    "adura vita" => ["Ultimate Healing Rune", "Attack"],
    "adori gran flam" => ["Great Fireball Rune", "Attack"]

];

$runasRetronia = [
    "adana mort" => ["name" => "Animate Dead Rune", "mlvl" => 2],
    "adana pox" => ["name" => "Antidote Rune", "mlvl" => 0],
    "adori gran frigo" => ["name" => "Avalanche Rune", "mlvl" => 5],
    "" => ["name" => "Blank Rune", "mlvl" => 0],
    "adevo ina" => ["name" => "Chameleon Rune", "mlvl" => 4],
    "adeta sio" => ["name" => "Convince Creature Rune", "mlvl" => 5],
    "adito tera" => ["name" => "Desintegrate Rune", "mlvl" => 4],
    "adito grav" => ["name" => "Destroy Field Rune", "mlvl" => 3],
    "adevo mas vis" => ["name" => "Energy Bomb Rune", "mlvl" => 10],
    "adevo grav vis" => ["name" => "Energy Field Rune", "mlvl" => 3],
    "adevo mas grav vis" => ["name" => "Energy Wall Rune", "mlvl" => 9],
    "adevo res pox" => ["name" => "Envenom Rune", "mlvl" => 4],
    "adevo mas hur" => ["name" => "Explosion Rune", "mlvl" => 6],
    "adevo grav flam" => ["name" => "Fire Field Rune", "mlvl" => 1],
    "adevo mas grav flam" => ["name" => "Fire Wall Rune", "mlvl" => 6],
    "adori flam" => ["name" => "Fireball Rune", "mlvl" => 2],
    "adevo mas flam" => ["name" => "Firebomb Rune", "mlvl" => 5],
    "adori gran flam" => ["name" => "Great Fireball Rune", "mlvl" => 4],
    "adori gran" => ["name" => "Heavy Magic Missile Rune", "mlvl" => 3],
    "adori frigo" => ["name" => "Icicle Rune", "mlvl" => 4],
    "adura gran" => ["name" => "Intense Healing Rune", "mlvl" => 1],
    "adori" => ["name" => "Light Magic Missile Rune", "mlvl" => 0],
    "adevo grav tera" => ["name" => "Magic Wall Rune", "mlvl" => 9],
    "adana ani" => ["name" => "Paralyze Rune", "mlvl" => 18],
    "adevo mas pox" => ["name" => "Poison Bomb Rune", "mlvl" => 4],
    "adevo grav pox" => ["name" => "Poison Field Rune", "mlvl" => 1],
    "adevo mas grav pox" => ["name" => "Poison Wall Rune", "mlvl" => 5],
    "adevo res flam" => ["name" => "Soulfire Rune", "mlvl" => 7],
    "adori vita vis" => ["name" => "Sudden Death Rune", "mlvl" => 15],
    "adura vita" => ["name" => "Ultimate Healing Rune", "mlvl" => 4],
];


function searchRune($name, $runas) {
    foreach ($runas as $key => $value) {
        if ($value["name"] === $name) {  
            return $key;  
        }
    }
    return null;
}

$hasRune = searchRune($item, $runasRetronia);
$urlHasCode = isset($_GET['code']);
$urlHasSearch = isset($_GET['search']);   

function filterAndMapItems($items, $filterCallback, $additionalCondition = null) {
    $filteredItems = array_filter($items, $filterCallback, ARRAY_FILTER_USE_BOTH);

    return array_map(function ($item, $name) use ($additionalCondition) {

        return $item;

    }, $filteredItems, array_keys($filteredItems));
}

if ($hasRune != null) { 

    $key = $hasRune;

    $runeData = filterAndMapItems($all_items, function ($item) use ($key) { 
        return isset($item['attributes']['runespellname']) && $item['attributes']['runespellname'] === $key;
    });

    $foundItem = $runeData[0];
    $clientId = intval($foundItem['attributes']['clientid']);

    $monsters_with_item = [];

    foreach ($creatures as $creature) {
        foreach ($creature['loot'] as $loot) {

            if (strtolower($loot['clientId']) == $clientId) {
                $chance_numeric = $loot['chance'] / 100000;
                $chance_formatted = number_format($chance_numeric * 100, 2) . '%';
                
                $monsters_with_item[] = [
                    'monster' => $creature['name'],
                    'chance' => $chance_formatted,
                    'chance_numeric' => $chance_numeric 
                ];
                break; 
            }
        }
    }

}else{

    if($urlHasCode == true || $urlHasSearch == true){

        $monsters_with_item = [];

    }else{

        $monsters_with_item = [];

        foreach ($creatures as $creature) {
            foreach ($creature['loot'] as $loot) {

                if (strtolower($loot['name']) == strtolower($item)) {
                    $chance_numeric = $loot['chance'] / 100000;
                    $chance_formatted = number_format($chance_numeric * 100, 2) . '%';
                    
                    $monsters_with_item[] = [
                        'monster' => $creature['name'],
                        'chance' => $chance_formatted,
                        'chance_numeric' => $chance_numeric 
                    ];
                    break; 
                }
            }
        }

    }

    $foundItem = null;

    foreach ($all_items as $currentItem) {
        if (isset($currentItem['name']) && $currentItem['name'] === $item) {
            $foundItem = $currentItem;
            break;
        }
    }

    $foundItem = null;

    if ($urlHasCode) {
        foreach ($all_items as $currentItem) {

            if (isset($currentItem['id']) && $currentItem['id'] == $_GET['code']) {
                $foundItem = $currentItem;
                break;
            }
        }
    }elseif($urlHasSearch){

        foreach ($all_items as $currentItem) {
            if (isset($_GET['search']) && isset($currentItem['attributes']['clientid']) && $currentItem['attributes']['clientid'] == $_GET['search']) {
                $foundItem = $currentItem; 
                break; 
            }
        }

    } else {
        foreach ($all_items as $currentItem) {
            if (isset($currentItem['name']) && $currentItem['name'] === $item) {
                $foundItem = $currentItem;
                break;
            }
        }
    }

    if ($foundItem && isset($foundItem['attributes']['clientid'])) {
        $clientId = $foundItem['attributes']['clientid'];
    } else {

        echo "Client ID não encontrado para o item.";
    }
    
} 

usort($monsters_with_item, function ($a, $b) {
    return $b['chance_numeric'] <=> $a['chance_numeric'];
});

foreach ($monsters_with_item as &$entry) {
    unset($entry['chance_numeric']);
}
unset($entry);

if($hasRune != null){

    $name_search = trim(str_replace("Rune", "", $item));

    $npcs_buying = [];
    $npcs_selling = [];

    foreach ($npcs as $npc) {

        foreach ($npc['buy'] as $buy_item) {

            if ($buy_item['name'] == $name_search) {

                $npcs_buying[] = [
                    'name' => $npc['name'],
                    'price' => $buy_item['price'],
                    'location' => $npc['location'],
                    'position' => $npc['position']
                ];
                break;
            }
        }

    }

}elseif($urlHasCode){

    $npcs_buying = [];
    $npcs_selling = [];

    foreach ($npcs as $npc) {

        foreach ($npc['buy'] as $buy_item) {

            if(isset($buy_item['type'])){
                
                if ($buy_item['type'] == $_GET['code']) {

                    $npcs_buying[] = [
                        'name' => $npc['name'],
                        'price' => $buy_item['price'],
                        'location' => $npc['location'],
                        'position' => $npc['position']
                    ];
                    break;
                }

            }else{

                break;
            }
        }

        foreach ($npc['sell'] as $sell_item) {

            if(isset($sell_item['type'])){

                if ($sell_item['type'] == $_GET['code']) {

                    $npcs_selling[] = [
                        'name' => $npc['name'],
                        'price' => $sell_item['price'],
                        'location' => $npc['location'],
                        'position' => $npc['position']
                    ];
                    break;
                }

            }else{

                break;
            }
        }
    }

}else{

    $npcs_buying = [];
    $npcs_selling = [];


    foreach ($npcs as $npc) {

        foreach ($npc['buy'] as $buy_item) {

            if(isset($buy_item['clientId'])){
                
                if ($buy_item['clientId'] == $clientId) {

                    $npcs_buying[] = [
                        'name' => $npc['name'],
                        'price' => $buy_item['price'],
                        'location' => $npc['location'],
                        'position' => $npc['position']
                    ];
                    break;
                }

            }else{

                break;
            }
        }

        foreach ($npc['sell'] as $sell_item) {

            if(isset($sell_item['clientId'])){

                if ($sell_item['clientId'] == $clientId) {

                    $npcs_selling[] = [
                        'name' => $npc['name'],
                        'price' => $sell_item['price'],
                        'location' => $npc['location'],
                        'position' => $npc['position']
                    ];
                    break;
                }

            }else{

                break;
            }
        }
    }
}

//Tiers
$tiers = [

    'one-handed' => [ // Armas de curta distância de uma mão
        ['max_attack' => 31, 'tier' => 1],
        ['max_attack' => 35, 'tier' => 2],
        ['max_attack' => 39, 'tier' => 3],
        ['max_attack' => PHP_INT_MAX, 'tier' => 4],
    ],

    'two-handed' => [ // Armas de curta distância de duas mãos
        ['max_attack' => 44, 'tier' => 1],
        ['max_attack' => 49, 'tier' => 2],
        ['max_attack' => 59, 'tier' => 3],
        ['max_attack' => PHP_INT_MAX, 'tier' => 4],
    ],

    'distance-one-handed' => [ // Armas de longa distância de uma mão
        ['max_attack' => 31, 'tier' => 1],
        ['max_attack' => 35, 'tier' => 2],
        ['max_attack' => 39, 'tier' => 3],
        ['max_attack' => PHP_INT_MAX, 'tier' => 4],
    ],

    'distance-two-handed' => [ // Armas de longa distância de duas mãos
        ['max_attack' => 0, 'tier' => 1],
        ['max_attack' => 1, 'tier' => 2],
        ['max_attack' => 3, 'tier' => 3],
        ['max_attack' => PHP_INT_MAX, 'tier' => 4],
    ],

    'helmets' => [ // Tiers para helmets
        ['max_armor' => 6, 'tier' => 1],
        ['max_armor' => 8, 'tier' => 2],
        ['max_armor' => 10, 'tier' => 3],
        ['max_armor' => PHP_INT_MAX, 'tier' => 4],
    ],

    'armors' => [ // Tiers para armors
        ['max_armor' => 10, 'tier' => 1],
        ['max_armor' => 13, 'tier' => 2],
        ['max_armor' => 15, 'tier' => 3],
        ['max_armor' => PHP_INT_MAX, 'tier' => 4],
    ],

    'legs' => [ // Tiers para legs
        ['max_armor' => 7, 'tier' => 1],
        ['max_armor' => 8, 'tier' => 2],
        ['max_armor' => 9, 'tier' => 3],
        ['max_armor' => PHP_INT_MAX, 'tier' => 4],
    ],

    'boots' => [ // Tiers para boots
        ['max_armor' => 1, 'tier' => 1],
        ['max_armor' => 2, 'tier' => 2],
        ['max_armor' => 3, 'tier' => 3],
        ['max_armor' => PHP_INT_MAX, 'tier' => 4],
    ],

    'shields' => [ // Tiers para shields
        ['max_defense' => 29, 'tier' => 1],
        ['max_defense' => 33, 'tier' => 2],
        ['max_defense' => 35, 'tier' => 3],
        ['max_defense' => PHP_INT_MAX, 'tier' => 4],
    ],

    'special_cases' => [
        'helmets' => [ // Casos especiais para helmets
            [
                'name' => 'helmet of the ancients',
                'tier' => 4,
                'conditions' => [
                    'armor_exact' => 11, 
                ],
            ],
        ],
    ],

];

$item_categories = [
    'short_distance' => [
        'club',  
        'sword',  
        'axe',   
    ],
    
    'long_distance' => [ 
        'bow',   
        'crossbow'
    ],
    
    'armor' => [ 
        'helmet', 
        'chest',  
        'legs',   
        'boots', 
    ],

    'shield' => [ 
        'shield', 
    ],
];

$tools = [
    ["name" => "rope", "clientid" => "3003"],
    ["name" => "pitchfork", "clientid" => "3451"],
    ["name" => "rake", "clientid" => "3452"],
    ["name" => "broom", "clientid" => "3454"],
    ["name" => "hoe", "clientid" => "3455"],
    ["name" => "pick", "clientid" => "3456"],
    ["name" => "shovel", "clientid" => "3457"],
    ["name" => "wooden hammer", "clientid" => "3459"],
    ["name" => "saw", "clientid" => "3461"],
    ["name" => "small axe", "clientid" => "3462"],
    ["name" => "closed trap", "clientid" => "3481"],
    ["name" => "fishing rod", "clientid" => "3483"],
];

$lightSources = [
    ["name" => "lit candelabrum", "clientid" => "2912", "duration" => "3000", "lightlevel" => "6"],
    ["name" => "lit lamp", "clientid" => "2915", "duration" => "2000", "lightlevel" => "6"],
    ["name" => "lit candlestick", "clientid" => "2918", "duration" => "3000", "lightlevel" => "4"],
    ["name" => "lit torch", "clientid" => "2921", "duration" => "600", "lightlevel" => "7"],
];

$valuables = [
    ["name" => "silver brooch", "clientid" => "3017"],
    ["name" => "some golden fruits", "clientid" => "3020"],
    ["name" => "ancient tiara", "clientid" => "3022", "slottype" => "head", "raritytier" => "4"],
    ["name" => "holy scarab", "clientid" => "3023"],
    ["name" => "holy falcon", "clientid" => "3024"],
    ["name" => "white pearl", "clientid" => "3026"],
    ["name" => "black pearl", "clientid" => "3027"],
    ["name" => "small diamond", "clientid" => "3028"],
    ["name" => "small sapphire", "clientid" => "3029"],
    ["name" => "small ruby", "clientid" => "3030"],
    ["name" => "gold coin", "clientid" => "3031"],
    ["name" => "small emerald", "clientid" => "3032"],
    ["name" => "small amethyst", "clientid" => "3033"],
    ["name" => "talon", "clientid" => "3034"],
    ["name" => "platinum coin", "clientid" => "3035"],
    ["name" => "violet gem", "clientid" => "3036"],
    ["name" => "yellow gem", "clientid" => "3037"],
    ["name" => "green gem", "clientid" => "3038"],
    ["name" => "red gem", "clientid" => "3039"],
    ["name" => "gold nugget", "clientid" => "3040"],
    ["name" => "blue gem", "clientid" => "3041"],
    ["name" => "scarab coin", "clientid" => "3042"],
    ["name" => "crystal coin", "clientid" => "3043"],
    ["name" => "orichalcum pearl", "clientid" => "5021"],
    ["name" => "Ravenor coin", "clientid" => "5097"],
    ["name" => "halloween coin", "clientid" => "5207"],
];

$foods = [
    2676 => ['name' => 'banana', 'value' => 8],
    2677 => ['name' => 'blueberry', 'value' => 1],
    2689 => ['name' => 'bread', 'value' => 10],
    2691 => ['name' => 'brown bread', 'value' => 8],
    2362 => ['name' => 'carrot', 'value' => 8],
    2684 => ['name' => 'carrot', 'value' => 8],
    2696 => ['name' => 'cheese', 'value' => 9],
    2679 => ['name' => 'cherry', 'value' => 1],
    2678 => ['name' => 'coconut', 'value' => 18],
    2687 => ['name' => 'cookie', 'value' => 2],
    2686 => ['name' => 'corncob', 'value' => 9],
    2792 => ['name' => 'dark mushroom', 'value' => 6],
    2672 => ['name' => 'dragon ham', 'value' => 60],
    2695 => ['name' => 'egg', 'value' => 6],
    2667 => ['name' => 'fish', 'value' => 12],
    5109 => ['name' => 'frozen ham', 'value' => 90],
    2681 => ['name' => 'grapes', 'value' => 9],
    2671 => ['name' => 'ham', 'value' => 30],
    2666 => ['name' => 'meat', 'value' => 15],
    2682 => ['name' => 'melon', 'value' => 20],
    2669 => ['name' => 'northern pike', 'value' => 17],
    2675 => ['name' => 'orange', 'value' => 13],
    2790 => ['name' => 'orange mushroom', 'value' => 30],
    2673 => ['name' => 'pear', 'value' => 5],
    2683 => ['name' => 'pumpkin', 'value' => 17],
    2674 => ['name' => 'red apple', 'value' => 6],
    2788 => ['name' => 'red mushroom', 'value' => 4],
    2690 => ['name' => 'roll', 'value' => 3],
    2668 => ['name' => 'salmon', 'value' => 10],
    2670 => ['name' => 'shrimp', 'value' => 4],
    2793 => ['name' => 'some mushrooms', 'value' => 12],
    2794 => ['name' => 'some mushrooms', 'value' => 3],
    2685 => ['name' => 'tomato', 'value' => 6],
    2787 => ['name' => 'white mushroom', 'value' => 9],
    2791 => ['name' => 'wood mushroom', 'value' => 9]
];

$helmetsData = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['slottype']) && $item['attributes']['slottype'] === "head";
});

$uniqueHelmets = [];
foreach ($helmetsData as $helmet) {
    if ($helmet['name'] === "helmet of the ancients") {
        if (isset($uniqueHelmets['helmet_of_the_ancients'])) {
            continue;
        }
        $uniqueHelmets['helmet_of_the_ancients'] = $helmet;
    } else {
        $uniqueHelmets[] = $helmet;
    }
}

$helmetsData = array_values($uniqueHelmets);

$armorsData = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['slottype']) && $item['attributes']['slottype'] === "body";
});

$legsData = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['slottype']) && $item['attributes']['slottype'] === "legs";
});

$feetsData = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['slottype']) && $item['attributes']['slottype'] === "feet";
});

$shieldsData = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['weapontype']) && $item['attributes']['weapontype'] === "shield";
});

$axesData = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['weapontype']) && $item['attributes']['weapontype'] === "axe";
});

$clubsData = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['weapontype']) && $item['attributes']['weapontype'] === "club";
});

$swordsData = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['weapontype']) && $item['attributes']['weapontype'] === "sword";
});

$wandsData = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['weapontype']) && $item['attributes']['weapontype'] === "wand";
});

$trowingWeapons = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['shoottype']) && isset($item['attributes']['range']);
});

$crossbows = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['iscrossbow']) && $item['attributes']['iscrossbow'] === "true";
});

$bow = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['isbow']) && $item['attributes']['isbow'] === "true";
});

$boltQuiver = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['containersize']) && isset($item['attributes']['ammotype']) && $item['attributes']['ammotype'] === "bolt";
});

$arrowQuiver = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['containersize']) && isset($item['attributes']['ammotype']) && $item['attributes']['ammotype'] === "arrow";
});

$ammunitionData = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['weapontype']) && $item['attributes']['weapontype'] === "ammunition";
});

$amuletsData = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['slottype']) && $item['attributes']['slottype'] === "necklace";
});

$ringsData = filterAndMapItems($all_items, function ($item) {

    return isset($item['attributes']['slottype']) && $item['attributes']['slottype'] === "ring";
});

$bagsData = filterAndMapItems($all_items, function ($item) {

    return isset($item['attributes']['slottype']) && $item['attributes']['slottype'] === "backpack";
});

$toolsData = filterAndMapItems($all_items, function ($item) use ($tools) {
    foreach ($tools as $tool) {
        if ( isset($item['attributes']['clientid']) && $tool['clientid'] === $item['attributes']['clientid']) {
            return true; 
        }
    }
    return false;
});

$lightSourcesData = filterAndMapItems($all_items, function ($item) use ($lightSources) {
    foreach ($lightSources as $tool) {
        if ( isset($item['attributes']['clientid']) && $tool['clientid'] === $item['attributes']['clientid']) {
            return true; 
        }
    }
    return false;
});

$foodsData = filterAndMapItems($all_items, function ($item) use ($foods) {
    foreach ($foods as $id => $tool) { 
        if (isset($item["id"]) && $id === $item["id"]) { 
            return true;
        }
    }
    return false;
});

$valuablesData = filterAndMapItems($all_items, function ($item) use ($valuables) {
    foreach ($valuables as $tool) {
        if ( isset($item['attributes']['clientid']) && $tool['clientid'] === $item['attributes']['clientid']) {
            return true; 
        }
    }
    return false;
});

$processedRingsData = [];
$seenNames = [];

foreach ($ringsData as $ring) {
    $name = $ring['name'];

    if (isset($seenNames[$name])) {
        continue;
    }

    $relatedItems = array_filter($all_items, function ($item) use ($name) {
        return isset($item['name']) && $item['name'] === $name;
    });

    $itemWithDuration = null;
    $itemWithStopDuration = null;

    foreach ($relatedItems as $relatedItem) {
        if (isset($relatedItem['attributes']['duration'])) {
            $itemWithDuration = $relatedItem;
        }
        if (isset($relatedItem['attributes']['stopduration'])) {
            $itemWithStopDuration = $relatedItem;
        }
    }

    if ($itemWithDuration) {

        if ($itemWithStopDuration) {
            $itemWithDuration['attributes']['clientid'] = $itemWithStopDuration['attributes']['clientid'];
        }

        $processedRingsData[] = $itemWithDuration;
    } elseif ($itemWithStopDuration) {
        continue;
    } else {
        $processedRingsData[] = $ring;
    }

    $seenNames[$name] = true;
}

$ringsData = $processedRingsData;


$runesData = filterAndMapItems($all_items, function ($item) {
    return isset($item['attributes']['type']) && $item['attributes']['type'] === "rune";
});

$category = null;

$itemData = [
    "helmets" => ['Helmets Data', $helmetsData],
    "armors" => ['Armors Data', $armorsData],
    "legs" => ['Legs Data', $legsData],
    "boots" => ['Boots Data', $feetsData],
    "shields" => ['Shields Data', $shieldsData],

    "axes" => ['Axes Data', $axesData], 
    "clubs" => ['Clubs Data', $clubsData],
    "swords" => ['Swords Data', $swordsData],
    "wands" => ['Wands Data', $wandsData],
    "throwing weapons" => ['Throwing Weapons Data', $trowingWeapons],

    "crossbow" => ['Crossbow Data', $crossbows],
    "bow" => ['Bow Data', $bow],
    "bolt quiver" => ['Bolt Quiver Data', $boltQuiver],
    "arrow quiver" => ['Arrow Quiver Data', $arrowQuiver],
    "ammunitions" => ['Ammunitions Data', $ammunitionData], 

    "amulets" => ['Amulets Data', $amuletsData],
    "rings" => ['Rings Data', $ringsData],
    "runes" => ['Runes Data', $runesData],
    "tools" => ['Tools Data', $toolsData],
    "lightsources" => ['Light Sources Data', $lightSourcesData],
    "containers" => ['Containers Data', $bagsData],
    "valuables" => ['Valuables Data', $valuablesData],
    "foods" => ['Foods Data', $foodsData],
];

foreach ($itemData as $categoryName => $categoryData) {
    $itemsArray = $categoryData[1];

    foreach ($itemsArray as $item) {
        if (isset($item['name']) && $item['name'] === $foundItem['name']) {
            $category = $categoryName;
            break 2; 
        }
    }
}

$jsonItemData = json_encode($itemData);

@endphp

<div id="itemData" data-item='<?php echo htmlspecialchars($jsonItemData, ENT_QUOTES, 'UTF-8'); ?>'></div>

<style>
    .LabelV176{

        padding: 2 !important;
        font-weight: bold;
        width: 200px;
    }

    .beaut_border {
        background-color: hsla(0,0%,100%,.46);
        box-shadow: 0 0 10px rgba(0,0,0,.5);
    }

    .description {
        color: #00F000;
        font-family: Verdana,Tahoma;
        font-size: 8pt;
        font-weight: bold;
        text-shadow: 0.1em 0.1em 0.08em #000,-0.1em -0.1em 0.08em #000,0.1em -0.1em 0.08em #000,-0.1em 0.1em 0.08em #000,-0.1em 0 0.08em #000,0.1em 0 0.08em #000;
        text-decoration: none;
        line-height: normal;
        display: inline-block; width: 40%;
    }

</style>

<small id="item-path"><b><a href="/about/items">Items</a> » <a href="/about/itemsView/{{ ucfirst($category) }}">{{ ucwords($category) }}</a> » {{ ucwords(str_replace("'", "", $foundItem['name'])) }}</b></small>

<br><br>

<style>
    .creatureListBoxNew {
        height: 90px;
        width: 150px;
        text-align: center;
        font: bold 12px Arial;
        display: flex;
        flex-direction: column;
        justify-content: center; 
        align-items: center; 
        position: relative;

    }

    .outfitImg {
        background-position: center center;
        background-repeat: no-repeat;
        width: 64px;
        height: 64px;
        padding: 5px;
        position: relative;
        overflow: hidden;

    }

    input[type="text"], input[type="number"], select {
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        height: 25px; 
        width: 200px; 
        margin: 0 auto;
    }

    input[type="text"]:focus, input[type="number"]:focus, select:focus {
        border-color: #007bff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .item_search_input {
        transition: box-shadow 0.3s ease;
    }

    .item_search_input:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }
</style>

<div>
    <div style="display: inline-block; position: relative;">
        <span style="position: absolute; left: 7px; top: 50%; transform: translateY(-50%);">
            <img src="/images/ser1.png" alt="Ícone de Pesquisa" style="width: 20px; height: 20px;">
        </span>
        <input id="search_creature" type="text" class="item_search_input" name="search_creature" value="" placeholder="Search Item.." style="padding-left: 30px;">
    </div>
</div>

<br>

@php
    $jsonRunasRetronia = json_encode($runasRetronia, JSON_UNESCAPED_UNICODE);
@endphp

<div id="runasRetronia" data-runas='<?php echo htmlspecialchars($jsonRunasRetronia, ENT_QUOTES, 'UTF-8'); ?>'></div>

<div id="monsterSearch" style="display: none" > 
 
    <div class="CaptionContainer">
    <div class="CaptionInnerContainer"> <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
        <div class="Text">Creatures</div>
        <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span> <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> </div>
    </div>

    <table class="Table3" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
        <td><div class="InnerTableContainer">
            <table style="width:100%;">
                <tbody>
                <tr>
                    <td><div class="TableContentContainer">
                        <table id="tableContainer" class="TableContent" width="100%" style="border:1px solid #faf0d7;">

                        </table>                    

                        <script>

                            const runasRetronia = JSON.parse(document.getElementById('runasRetronia').dataset.runas);

                            const itemData = JSON.parse(document.getElementById('itemData').getAttribute('data-item'));
                            
                            const itemTable = document.getElementById('tableContainer');
                        
                            for (const [itemType, itemDetails] of Object.entries(itemData)) {

                                const itemName = itemDetails[0]; 
                                const creatures = itemDetails[1];

                                const headerRow = document.createElement('tr');
                                const headerCell = document.createElement('th');
                                headerCell.colSpan = 5; 
                                headerCell.textContent = itemName; 
                                headerRow.appendChild(headerCell);
                                itemTable.appendChild(headerRow);
                        
                                let columnCount = 0;
                                let row; 

                                creatures.forEach((item, index) => {

                                    if (item.name == "reward spell rune") {
                                        return;
                                    }

                                    if (item.attributes && item.attributes.runespellname && item.name == "spell rune") {

                                        finalName = item.name;

                                        for (let key in runasRetronia) {

                                            if (key === item.attributes.runespellname) {

                                                finalName = runasRetronia[key].name;
                                            }
                                        }

                                    }else{

                                        finalName = item.name;
                                    }

                                    if(finalName == "spell rune" || finalName == "emblem backpack"){

                                        return;
                                    }

                                    if (columnCount % 5 === 0) {
                                        row = document.createElement('tr'); 
                                        itemTable.appendChild(row); 
                                    }

                                    const cell = document.createElement('td');
                                    cell.id = item.name; 
                                    cell.className = 'monster'; 
                                    cell.style.border = '2px solid rgba(121, 61, 3, 0.65)';
                                    cell.style.borderRadius = '10px';
                                    cell.style.backgroundColor = 'rgba(255, 255, 255, 0.46)';
                                    cell.style.boxShadow = '0 0 10px rgba(0, 0, 0, 0.5)';

                                    cell.innerHTML = `
                                        <br>
                                        <div onclick="fillTableWithRunes('${item.id}', '${itemType}')" style="cursor: pointer;">
                                            <div class="creatureListBoxNew">
                                                <img src="/items/${item.attributes.clientid}.gif" alt="${item.name}"/>
                                                <label style="position: absolute; left: 50%; top: 90%; transform: translate(-50%, -50%); width: 100px">${finalName}</label>
                                            </div>
                                        </div>
                                        <br>
                                    `;
   
                                    row.appendChild(cell);
                                    columnCount++;
                                });
                            }
                        </script>

                    </div></td>
                </tr>
                </tbody>
            </table>
            </div></td>
        </tr>
    </tbody>
    </table>
</div>

<script>
    function createTable(monsters) {
        const tableContainer = document.getElementById('monsterSearch');
        tableContainer.innerHTML = '';

        if (monsters.length === 0) {
            return;
        }

        let tableHTML = '<table style="width: 100%;"><tbody>';
        const numColumns = 5;
        let rowStarted = false;

        for (let i = 0; i < monsters.length && i < 5; i++) {
            if (i % numColumns === 0) {
                if (rowStarted) tableHTML += '</tr>';
                tableHTML += '<tr>';
                rowStarted = true;
            }

            tableHTML += `${monsters[i].outerHTML}`;
        }

        if (rowStarted) tableHTML += '</tr>';
        tableHTML += '</tbody></table>';
        tableContainer.innerHTML = tableHTML;
        tableContainer.style.display = ''; 
    }

    const allMonsters = Array.from(document.querySelectorAll('.monster'));

    createTable([]);

    document.querySelector('.item_search_input').addEventListener('input', function () {
        const searchTerm = this.value.trim().toLowerCase();

        if (searchTerm === '') {
            createTable([]);
            return;
        }

        const filteredMonsters = allMonsters.filter((monster) => {
            const monsterName = monster.textContent.trim().toLowerCase();
            
            const monsterWords = monsterName.split(' ');

            const searchWords = searchTerm.split(' ');

            const matches = searchWords.every(searchWord => 
                monsterWords.some(monsterWord => monsterWord.startsWith(searchWord))
            );

            return matches;
        });

        filteredMonsters.sort((a, b) => {
            const aName = a.textContent.trim().toLowerCase();
            const bName = b.textContent.trim().toLowerCase();

            const aStartsWith = aName.startsWith(searchTerm);
            const bStartsWith = bName.startsWith(searchTerm);

            if (aStartsWith && !bStartsWith) {
                return -1; 
            } else if (!aStartsWith && bStartsWith) {
                return 1;
            }
            return 0; 
        });

        createTable(filteredMonsters.slice(0, 5));
    });

</script>

@php
    $jsonItemTableData = json_encode($all_items, JSON_UNESCAPED_UNICODE);
@endphp

<div id="itemTableData" data-item='<?php echo htmlspecialchars($jsonItemTableData, ENT_QUOTES, 'UTF-8'); ?>'></div>

<br>

<table class="Table3" cellpadding="0" cellspacing="0" style="width: 100%">
    <tbody>
    <tr>
        <td>
            <div class="TableScrollbarWrapper" style="width: unset;">
                <div class="TableScrollbarContainer"></div>
            </div>
            <div class="InnerTableContainer" style="max-width: unset;">
                <table style="width:100%;">
                    <tbody>
                    <tr>
                        <td>
                            <div class="TableContentContainer">
                                <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                    <tbody>
                                    <tr class="LabelH" >
                                        <td class="beaut_border"  style="border:1px solid #faf0d7;">Image</td>
                                        <td class="beaut_border"  style="border:1px solid #faf0d7;">Name</td>
                                    </tr>
                                    <tr class="Even">
                                        <td id="itemImage" style="width: 1%; border:1px solid #faf0d7;">
                                            <div style="position: relative; padding: 15px">
                                            </div>
                                        </td>
                                        <td id="itemName" style="width: 99%">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </td>
    </tr>

    <tr>
        <td>
            <div class="TableScrollbarWrapper" style="width: unset;">
                <div class="TableScrollbarContainer"></div>
            </div>
            <div class="InnerTableContainer" style="max-width: unset;">
                <table id="correctColors" style="width:100%;">
                    <tbody>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table id="tabelaAttributes" class="TableContent" width="100%" style="border:1px solid #faf0d7;">                                                                                                  
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </td>
    </tr>

    </tbody>
</table>

<script>
    const foundItemId = {{ $foundItem['id'] }};
    const allItems = {!! json_encode($all_items) !!};
    const creatures = {!! json_encode($creatures) !!};
    const runas = {!! json_encode($runas) !!};
    const npcs = {!! json_encode($npcs) !!};
</script>

<script src="{{ asset('assets/tibiarl/js/about/wiki/itemPage.min.js') }}?v=2" defer></script>

<script>
    function toggleRow(img) {
        const row = img.closest('tr').nextElementSibling;

        if (row.style.display === 'none') {
            row.style.display = 'table-row';
            img.src = '/images/circle-symbol-plus.gif';
        } else {
            row.style.display = 'none';
            img.src = '/images/circle-symbol-minus.gif'; 
        }
    }
</script>

<br>

<center>
<div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton.gif)" onclick="javascript:history.go(-1)">
    <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(&quot;/assets/tibiarl/images/buttons/sbutton_over.gif&quot;); visibility: hidden;"></div>
        <input class="BigButtonText" type="submit" value="Back">
    </div>
</div>
</center>

<link rel="stylesheet" href="{{ asset('assets/tibiarl/css/about/wiki/creaturesView.css') }}?v=2">


@endsection

