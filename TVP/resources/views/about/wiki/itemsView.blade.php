@extends('template.layout')
@section('title', 'Items')
@section('submenuItem', 'items')
@section('content')

    <style>
        .creatureListBox {
            height: 90px;
            width: 80px;
            text-align: center;
            vertical-align: middle;
            font: bold 12px arial;
            display: inline-table;
            margin-left: 18px;
        }

        .outfitImg {
            background-position: center center;
            background-repeat: no-repeat;
            width: 64px;
            height: 64px;
            padding: 5px;
            position: relative;
            overflow: hidden;
            border: 2px solid rgba(121, 61, 3, 0.65);
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.46);
        }

        .itemImg {
            background-position: center center;
            background-repeat: no-repeat;
            width: 30px;
            height: 30px;
            padding: 5px;
            position: relative;
            overflow: hidden;
            border: 2px solid rgba(121, 61, 3, 0.65);
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.46);
        }

        @font-face {
            font-family: 'Martel';
            src: url('https://ravenor.online/martel.ttf') format('truetype');
        }

        td{

            border: 2px solid rgba(121, 61, 3, 0.65);
            background-color: rgba(255, 255, 255, 0.46);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .LabelV175{

            padding: 10px !important;
        }

    </style>

    @php

        if (!function_exists('generateItemTable')) {
            function generateItemTable($title, $items, $additionalFields, $additionalNames, $serverPath) {

                $weapons = ["Axes Data", "Clubs Data", "Swords Data"];
                $skillRing = ["skillfist", "skillaxe", "skillclub", "skillsword"];
                $skillSolo = ["suppressdrunk", "invisible", "manashield"];
                $skillGain = ["healthgain", "managain"];
                $skillExclude = ["healthticks", "manaticks"];
                $armorSet = ["Helmets Data", "Armors Data", "Legs Data", "Boots Data"];
                $toggleClass = "Odd";

                $propetyWeapon = ($title == "Shields Data") ? "Defense" : "Armor";

                $categories = [
                    "weapons" => $weapons,
                    "distances" => ["Distances Data"],
                    "ammunitions" => ["Ammunitions Data"],
                    "runes" => ["Runes Data"],
                    "tools" => ["Tools Data", "Valuables Data", "Light Sources Data"],
                    "rings" => ["Rings Data"],
                    "containers" => ["Containers Data"],
                    "armor" => $armorSet,
                    "shields" => ["Shields Data"],
                    "crossbow" => ["Distances Weapons Data"],
                    "throwingWeapons" => ["Throwing Weapons Data"],
                    "boltQuiver" => ["Quivers Data"],
                    "wands" => ["Wands Data"],
                    "foods" => ["Foods Data"]
                ];

                $columnsMap = [
                    "armor" => "
                        <td style='width: 50px'>Image</td>
                        <td>Name <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                        <td>Weight <small><a href='#' class='sort' data-column='weight'>[Sort]</a></small></td>
                        <td>$propetyWeapon <small><a href='#' class='sort' data-column='armor'>[Sort]</a></small></td>
                        <td>Tier <small><a href='#' class='sort' data-column='tier'>[Sort]</a></small></td>
                        <td>Additional</td>",
                    "shields" => "
                        <td style='width: 50px'>Image</td>
                        <td>Name <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                        <td>Weight <small><a href='#' class='sort' data-column='weight'>[Sort]</a></small></td>
                        <td>$propetyWeapon <small><a href='#' class='sort' data-column='armor'>[Sort]</a></small></td>
                        <td>Tier <small><a href='#' class='sort' data-column='tier'>[Sort]</a></small></td>
                        <td>Additional</td>",
                    "weapons" => "
                        <td style='width: 50px'>Image</td>
                        <td>Name <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                        <td>Attack <small><a href='#' class='sort' data-column='attack'>[Sort]</a></small></td>
                        <td>Defense <small><a href='#' class='sort' data-column='armor'>[Sort]</a></small></td>
                        <td>Hands</td>
                        <td>Tier <small><a href='#' class='sort' data-column='tier'>[Sort]</a></small></td>
                        <td>Additional</td>
                        <td>Weight <small><a href='#' class='sort' data-column='weight'>[Sort]</a></small></td>",
                    "wands" => "
                        <td style='width: 50px'>Image</td>
                        <td>Name <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                        <td>Weight <small><a href='#' class='sort' data-column='weight'>[Sort]</a></small></td>
                        <td>Tier <small><a href='#' class='sort' data-column='tier'>[Sort]</a></small></td>
                        <td>Additional</td>",
                    "throwingWeapons" => "
                        <td style='width: 50px'>Image</td>
                        <td>Name <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                        <td>Range</td>
                        <td>Hands</td>
                        <td>Weight  <small><a href='#' class='sort' data-column='weight'>[Sort]</a></small></td>",
                    "crossbow" => "
                        <td style='width: 50px'>Image</td>
                        <td>Name <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                        <td>Range</td>
                        <td>Hands</td>
                        <td>Ammo</td>
                        <td>Tier  <small><a href='#' class='sort' data-column='tier'>[Sort]</a></small></td>
                        <td>Additional</td>
                        <td>Weight  <small><a href='#' class='sort' data-column='weight'>[Sort]</a></small></td>",
                    "boltQuiver" => "
                        <td style='width: 50px'>Image</td>
                        <td>Name <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                        <td>Ammo</td>
                        <td>Weight  <small><a href='#' class='sort' data-column='weight'>[Sort]</a></small></td>
                        <td>Tier <small><a href='#' class='sort' data-column='tier'>[Sort]</a></small></td>
                        <td>Slots  <small><a href='#' class='sort' data-column='armor'>[Sort]</a></small></td>
                        ",
                    "ammunitions" => "
                        <td style='width: 50px'>Image</td>
                        <td>Name <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                        <td>Attack <small><a href='#' class='sort' data-column='attack'>[Sort]</a></small></td>
                        <td>Ammo</td>
                        <td>Weight <small><a href='#' class='sort' data-column='weight'>[Sort]</a></small></td>
                        <td>Additional</td>",
                    "runes" => "
                        <td style='width: 50px'>Image</td>
                        <td>Name  <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                        <td>Group</td>
                        <td>Mlvl <small><a href='#' class='sort' data-column='armor'>[Sort]</a></small></td>
                        <td>Spell</td>
                        <td>Weight <small><a href='#' class='sort' data-column='weight'>[Sort]</a></small></td>
                        ",
                    "tools" => "
                        <td style='width: 50px'>Image</td>
                        <td>Name <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                        <td>Description</td>
                        <td>Weight <small><a href='#' class='sort' data-column='weight'>[Sort]</a></small></td>",
                    "rings" => "
                        <td style='width: 50px'>Image</td>
                        <td>Name <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                        <td>Weight <small><a href='#' class='sort' data-column='weight'>[Sort]</a></small></td>
                        <td>Additional</td>",
                    "containers" => "
                        <td style='width: 50px'>Image</td>
                        <td>Name <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                        <td>Slots <small><a href='#' class='sort' data-column='armor'>[Sort]</a></small></td>
                        <td>Additional</td>
                        <td>Weight <small><a href='#' class='sort' data-column='weight'>[Sort]</a></small></td>",
                    "foods" => "
                        <td style='width: 50px'>Image</td>
                        <td>Name <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                        <td>Regeneration Time  <small><a href='#' class='sort' data-column='regeneration'>[Sort]</a></small></td>
                        <td>Description</td>
                        <td>Weight <small><a href='#' class='sort' data-column='weight'>[Sort]</a></small></td>",
                    "default" => "
                        <td style='width: 50px'>Image</td>
                        <td>Name <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                        <td>Weight <small><a href='#' class='sort' data-column='weight'>[Sort]</a></small></td>
                        <td>$propetyWeapon <small><a href='#' class='sort' data-column='tier'>[Sort]</a></small></td>
                        <td>Additional</td>"
                ];

                foreach ($categories as $key => $titles) {
                    if (in_array($title, $titles)) {
                        $category = $key;
                        break;
                    }
                }

                $columnsTable = $columnsMap[$category];

                $tableHtml = "
                <div class='TableContainer'>
                    <div class='CaptionContainer'>
                        <div class='CaptionInnerContainer'>
                            <span class='CaptionEdgeLeftTop' style='background-image:url(https://ravenor.online/assets/tibiarl/images/content/box-frame-edge.gif);'></span>
                            <span class='CaptionEdgeRightTop' style='background-image:url(https://ravenor.online/assets/tibiarl/images/content/box-frame-edge.gif);'></span>
                            <span class='CaptionBorderTop' style='background-image:url(https://ravenor.online/assets/tibiarl/images/content/table-headline-border.gif);'></span>
                            <span class='CaptionVerticalLeft' style='background-image:url(https://ravenor.online/assets/tibiarl/images/content/box-frame-vertical.gif);'></span>
                            <div class='Text'>" .  str_replace('Data', '', $title) . "</div>
                            <span class='CaptionVerticalRight' style='background-image:url(https://ravenor.online/assets/tibiarl/images/content/box-frame-vertical.gif);'></span>
                            <span class='CaptionBorderBottom' style='background-image:url(https://ravenor.online/assets/tibiarl/images/content/table-headline-border.gif);'></span>
                            <span class='CaptionEdgeLeftBottom' style='background-image:url(https://ravenor.online/assets/tibiarl/images/content/box-frame-edge.gif);'></span>
                            <span class='CaptionEdgeRightBottom' style='background-image:url(https://ravenor.online/assets/tibiarl/images/content/box-frame-edge.gif);'></span>
                        </div>
                    </div>
                    <table class='Table3' cellpadding='0' cellspacing='0'>
                        <tbody>
                            <tr>
                                <td>
                                    <div class='TableScrollbarWrapper' style='width: unset;'>
                                        <div class='TableScrollbarContainer'></div>
                                    </div>
                                    <div class='InnerTableContainer' style='max-width: unset;'>
                                        <table style='width:100%;'>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class='TableContentContainer'>
                                                            <table class='TableContent' width='100%' style='border:1px solid #faf0d7;'>
                                                                <tbody>
                                                                    <tr class='LabelH'>
                                                                        $columnsTable
                                                                    </tr>";
                                                                        
                $class = 'f1e0c6';
                $displayedItems = array();
                $runeDex = 0;
                                               
                foreach($items as $item) {

                    try {

                        $itemWeight = 0;
                        $itemName = "";
                        $clientId = "";

                        if(isset($item['weight'])){
                            $itemWeight = $item['weight'];
                        }

                        if(isset($item['name'])){
                            $itemName = $item['name'];
                        }

                        if(isset($item['clientid'])){
                            $clientId = $item['clientid'];
                        }

                        if($itemName == "") continue;

                        $weightFormatted = number_format($itemWeight / 100, 2, '.', '');
                        $nameFormatted = ucwords(strtolower($itemName));

                        if (stripos($item['name'], 'reward spell rune') !== false) continue;

                        $toggleClass = ($toggleClass === "Odd") ? "Even" : "Odd";
                        $class = "";

                        if(in_array($title, $armorSet)){

                            $tableHtml .= generateArmorsRow($item, $serverPath, $toggleClass, $nameFormatted);

                        }elseif($title == "Shields Data"){

                            $tableHtml .= generateShieldsRow($item, $serverPath, $toggleClass, $nameFormatted);

                        }elseif(in_array($title, $weapons)){  

                            $tableHtml .= generateWeaponsRow($item, $serverPath, $toggleClass, $nameFormatted);

                        }elseif($title == "Wands Data"){

                            $tableHtml .= generateWandsRow($item, $serverPath, $toggleClass, $nameFormatted);

                        }elseif($title == "Throwing Weapons Data"){

                            $tableHtml .= generateThrowingWeaponsRow($item, $serverPath, $toggleClass, $nameFormatted);

                        }elseif($title == "Distances Weapons Data"){

                            $tableHtml .= generateCrossbowRow($item, $serverPath, $toggleClass, $nameFormatted);

                        }elseif($title == "Quivers Data"){

                            $tableHtml .= generateBowQuiverRow($item, $serverPath, $toggleClass, $nameFormatted);

                        }elseif($title == "Ammunitions Data"){

                            $tableHtml .= generateAmmunitionRow($item, $serverPath, $toggleClass, $nameFormatted);

                        }elseif($title == "Amulets Data"){
                        
                            $tableHtml .= generateAmuletsRow($item, $serverPath, $toggleClass, $nameFormatted);

                        }elseif($title == "Rings Data"){
                                                
                            $tableHtml .= generateRingsRow($item, $serverPath, $toggleClass, $nameFormatted);

                        }elseif($title == "Runes Data"){

                            if($runeDex == 0){

                                $tableHtml .= "<tr class='rowPage $toggleClass'>
                                    <td><img src='$serverPath/items/3147.gif'></td>
                                    <td><a href='/about/itemPage/" . urlencode("blank rune") . "'><span>blank rune</span></a></td>
                                    <td>Support</td>
                                    <td data-column='armor'>0</td>
                                    <td data-column='name'>Does not have.</td>
                                    <td>1.20 oz</td>
                                ";

                                $toggleClass = ($toggleClass === "Odd") ? "Even" : "Odd";
                            }

                            $runeDex = 1;

                            // if(!isset($item["attributes"]['runespellname'])){

 
                            //     $toggleClass = ($toggleClass === "Odd") ? "Even" : "Odd";
                            //     continue;
                            // }

                            $tableHtml .= generateRunesRow($item, $serverPath, $toggleClass, $nameFormatted);

                        }elseif($title == "Foods Data"){

                            $tableHtml .= generateFoodsRow($item, $serverPath, $toggleClass, $nameFormatted);

                        }elseif($title == "Tools Data" || $title == "Light Sources Data" || $title == "Rings Data" || $title == "Valuables Data"){

                            $tableHtml .= generateUtilsRow($item, $serverPath, $toggleClass, $nameFormatted);

                        }elseif($title == "Containers Data"){

                            $tableHtml .= generateBagsRow($item, $serverPath, $toggleClass, $nameFormatted);
                        }

                    }catch (\Throwable $th) {
                        //throw $th;
                    }

                    $tableHtml .= "</td>
                        
                    </tr>";
                }

                $tableHtml .= "
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
                        </tbody>
                    </table>
                </div>";

                return $tableHtml;
                }

        }

        $item = strtolower((string)$item);
        $item = preg_replace('/[^a-z]/', '', $item);
        $serverPath = "";

        include "./items.php";
        include "./itemsFunctions.php";  

        function filterAndMapItems($items, $filterCallback, $additionalCondition = null) {
            $filteredItems = array_filter($items, $filterCallback, ARRAY_FILTER_USE_BOTH);

            return array_map(function ($item, $name) use ($additionalCondition) {

                return $item;

            }, $filteredItems, array_keys($filteredItems));
        }

        function sortByArmorDesc(&$items) {
            usort($items, function ($a, $b) {
                $armorA = $a['attributes']['armor'] ?? 0;
                $armorB = $b['attributes']['armor'] ?? 0; 
                return $armorA <=> $armorB; 
            });
        }

        function sortByDefenseDesc(&$items) {
            usort($items, function ($a, $b) {
                $defenseA = $a['attributes']['defense'] ?? 0;
                $defenseB = $b['attributes']['defense'] ?? 0; 
                return $defenseA <=> $defenseB; 
            });
        }

        function sortByAttackDesc(&$items) {
            usort($items, function ($a, $b) {
                $attackA = $a['attributes']['attack'] ?? 0;
                $attackB = $b['attributes']['attack'] ?? 0; 
                return $attackA <=> $attackB; 
            });
        }

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
            return (isset($item['attributes']['iscrossbow']) && $item['attributes']['iscrossbow'] === "true") || 
                (isset($item['attributes']['isbow']) && $item['attributes']['isbow'] === "true");
        });

        $quivers = filterAndMapItems($all_items, function ($item) {
            return isset($item['attributes']['containersize']) && isset($item['attributes']['ammotype']);
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

        usort($bagsData, function ($a, $b) {
            $sizeA = $a["attributes"]['containersize'] ?? 0;
            $sizeB = $b["attributes"]['containersize'] ?? 0;
            return $sizeA - $sizeB;
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

        usort($foodsData, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
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

        sortByArmorDesc($helmetsData);
        sortByArmorDesc($armorsData);
        sortByArmorDesc($legsData);
        sortByArmorDesc($feetsData);
        sortByDefenseDesc($shieldsData);
        sortByAttackDesc($axesData);
        sortByAttackDesc($clubsData);
        sortByAttackDesc($swordsData);
        sortByAttackDesc($ammunitionData);
        sortByArmorDesc($amuletsData);

        $additionalFields = ['absorbpercentphysical', 'absorbpercentfire', 'absorbpercentpoison', 'absorbpercentenergy', 'absorbpercentmanadrain', 'absorbpercentlifedrain', 'duration', 'charges', "desc", "skillfist", "skillaxe", "skillclub", "skillsword", "manashield", "suppressdrunk", "healthgain", "healthticks", "managain", "manaticks", "invisible"];

        $additionalNames = [
            'absorbpercentphysical' => 'Protection Physical', 
            'absorbpercentfire' => 'Protection Fire', 
            'absorbpercentpoison' => 'Protection Poison', 
            'absorbpercentenergy' => 'Protection Energy', 
            'absorbpercentmanadrain' => 'Protection Mana Drain', 
            'absorbpercentlifedrain' => 'Protection Life Drain', 
            'duration' => 'Duration Time',
            'charges' => 'uses',
            'desc' => '',
            'skillfist' => 'Skill Fist',
            'skillaxe' => 'Skill Axe',
            'skillsword' => 'Skill Sword',
            'skillclub' => 'Skill Club ',
            'manashield' => 'Give Mana Shield',
            'suppressdrunk' => 'Suppress Drunk',
            'healthgain' => 'Health Gain',
            'healthticks' => 'Health Ticks',
            'managain' => 'Mana Gain',
            'manaticks' => 'Mana Ticks',
            'invisible' => 'Make you Invisible'
        ];

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
            "throwingweapons" => ['Throwing Weapons Data', $trowingWeapons],

            "crossbow" => ['Crossbow Data', $crossbows],
            "distancesweapons" => ['Distances Weapons Data', $bow],
            "quivers" => ['Quivers Data', $quivers],
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

        if (array_key_exists($item, $itemData)) {

            $itemInfo = $itemData[$item];
            
            echo generateItemTable($itemInfo[0], $itemInfo[1], $additionalFields, $additionalNames, $serverPath);

        } else {

            echo "Non-existent category.";
        }


    @endphp

    <br>

    <center>
        <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton.gif)" onclick="javascript:history.go(-1)">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_over.gif); visibility: hidden;"></div>
                <input class="BigButtonText" type="submit" value="Back">
            </div>
        </div>
    </center>

    <script>

        $(document).ready(function () {
            function sortTable(column, descending) {
                $('table.TableContent tbody tr.rowPage').removeClass('Odd Even');

                var rows = $('table.TableContent tbody tr.rowPage').get();

                rows.sort(function (a, b) {
                    var cellA = $(a).find('td[data-column="' + column + '"]').text().trim();
                    var cellB = $(b).find('td[data-column="' + column + '"]').text().trim();

                    if (column === 'weight' || column === 'regeneration') {
                        cellA = cellA.match(/[\d.]+/) ? parseFloat(cellA.match(/[\d.]+/)[0]) : 0;
                        cellB = cellB.match(/[\d.]+/) ? parseFloat(cellB.match(/[\d.]+/)[0]) : 0;
                    }

                    if (column === 'name') {
                        cellA = cellA.toLowerCase(); 
                        cellB = cellB.toLowerCase();
                        if (descending) {
                            return cellA > cellB ? 1 : cellA < cellB ? -1 : 0;
                        } else {
                            return cellA < cellB ? 1 : cellA > cellB ? -1 : 0;
                        }
                    }

                    if ($.isNumeric(cellA) && $.isNumeric(cellB)) {
                        cellA = parseFloat(cellA);
                        cellB = parseFloat(cellB);
                    }

                    if (descending) {
                        return cellA < cellB ? 1 : cellA > cellB ? -1 : 0;
                    } else {
                        return cellA > cellB ? 1 : cellA < cellB ? -1 : 0;
                    }
                });

                $.each(rows, function (index, row) {
                    $('table.TableContent tbody').append(row);
                });

                $('table.TableContent tbody tr.rowPage').each(function (index) {
                    if (index % 2 === 0) {
                        $(this).addClass('Even');
                    } else {
                        $(this).addClass('Odd');
                    }
                });
            }

            $('.sort').click(function (event) {
                event.preventDefault();

                var column = $(this).data('column');
                var isDescending = $(this).text().trim() === '[Sort]';

                if (isDescending) {
                    $(this).text('[Unsort]');
                } else {
                    $(this).text('[Sort]');
                }

                sortTable(column, isDescending);
            });
        });

    </script>

@endsection