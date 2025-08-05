@extends('template.layout')
@section('title', 'creatures')
@section('submenuItem', 'creatures')
@section('content')

    @php 
    
        include "./monsterXml.php"; 

        $creature_name = $name;
        $index = array_search($creature_name, $creatures);
        $serverPath = '';

        $allMonsterData = [];

        foreach ($creatures as $index => $creature) {
            $creatureName = $creature["name"];
            $allMonsterData[$creatureName] = $index;
        }

        $formattedName = strtolower(str_replace(' ', '', $name));

        $creaturesOutfit = [
            "Amazon"       => ["addons" => 0, "head" => 113, "body" => 120, "legs" => 95,  "feet" => 115],
            "Assassin"     => ["addons" => 0, "head" => 95,  "body" => 95,  "legs" => 95,  "feet" => 95],
            "Bandit"       => ["addons" => 0, "head" => 58,  "body" => 40,  "legs" => 24,  "feet" => 95],
            "Ferumbras"    => ["addons" => 0, "head" => 57,  "body" => 113, "legs" => 95,  "feet" => 113],
            "Wild Warrior" => ["addons" => 0, "head" => 38,  "body" => 38,  "legs" => 38,  "feet" => 38],
            "Black Knight" => ["addons" => 0, "head" => 95,  "body" => 95,  "legs" => 95,  "feet" => 95],
            "Fury"         => ["addons" => 3, "head" => 94,  "body" => 77,  "legs" => 96,  "feet" => 0],
            "Hunter"       => ["addons" => 0, "head" => 95,  "body" => 116, "legs" => 120, "feet" => 115],
            "Smuggler"     => ["addons" => 0, "head" => 95,  "body" => 0,   "legs" => 113, "feet" => 115],
            "Stalker"      => ["addons" => 0, "head" => 97,  "body" => 116, "legs" => 95,  "feet" => 95],
            "Valkyrie"     => ["addons" => 0, "head" => 113, "body" => 38,  "legs" => 76,  "feet" => 96],
            "Warlock"      => ["addons" => 0, "head" => 0,   "body" => 52,  "legs" => 128, "feet" => 95],
        ];

        $creatureId = $creatures[$allMonsterData[$creature_name]]["type"];
        $creatureName = $creatures[$allMonsterData[$creature_name]]["name"];

        if(array_key_exists($creatureName, $creaturesOutfit)){
            $creatureAddon = $creaturesOutfit[$creatureName]["addons"];
            $creatureHead = $creaturesOutfit[$creatureName]["head"];
            $creatureBody = $creaturesOutfit[$creatureName]["body"];
            $creatureLeg = $creaturesOutfit[$creatureName]["legs"];
            $creatureFeet = $creaturesOutfit[$creatureName]["feet"];
            $creatureSrcInit = "/outfits/animoutfit.php?id=$creatureId&addons=$creatureAddon&head=$creatureHead&body=$creatureBody&legs=$creatureLeg&feet=$creatureFeet";
        } else {
            $creatureSrcInit = "/outfits/animoutfit.php?id=$creatureId.gif";
        }

        $numeroTotalCasos = 100000;
    
        $creaturesAlign = [

            "Amazon", "Assassin", "Bandit", "Black Knight", "Ferumbras", "Fernfang", "Fury", "Hunter", "Monk", "Smuggler", "Stalker", "Valkyrie", "Warlock", "Wild Warrior", "Witch", "Dark Monk", "Barbarian Skullhunter", "Barbarian Headsplitter", "Dworc Fleshhunter", "Dworc Voodoomaster", "Lion", "Crocodile", "Bonebeast", "Bear", "Centipede", "Orc Rider", "Polar Bear", "Panda", "Serpent Spawn", "Tiger", "War Wolf", "Grinch", "Evil Grinch", "Caiman"
        ];

        $creaturesAlign1 = [

            "Ashmunrah", "Barbarian Bloodwalker", "Barbarian Brutetamer", "Dipthrah", "Kongra", "Lizard Templar", "Lizard Snakecharmer", "Lizard Sentinel", "Mahrdis", "Lich", "Merlkin", "Morguthis", "Omruc", "Rahemos", "Novice Pumpkinhead", "Pumpkinhead", "Thalas", "Terror Bird", "Tarantula", "Vashresamun", "Sibang", "Stone Golem", "Spit Nettle", "Cyclops","Carniphila",
        ];

        $creaturesAlign2 = [

            "Ancient Scarab", "Crystal Spider", "Grorlam", "The Old Widow",
        ];

        $creaturesAlign3 = [

            "Elephant", "Hyaena",
        ];

        $creaturesAlign4 = [

            "Bat", "Badger", "Banshee", "Black Sheep", "Butterfly", "Bug", "Cave Rat", "Chicken", "Helper Elf", "Cobra", "Crab", "Crypt Shambler", "Deathslicer", "Deer", "Demon Skeleton", "Dog", "Dharalion", "Dummy Target", "Dummy Target", "Dwarf Geomancer", "Dwarf Guard", "Dwarf Soldier", "Dwarf", "Dworc Venomsniper", "Elf Arcanist", "Elf Scout", "Elf", "Fire Devil", "Fire Elemental", "Flamingo", "Frost Troll", "Gamemaster", "Gargoyle", "Gazer", "General Murius", "Ghost", "Ghoul", "Goblin", "Hero", "Larva", "Mimic", "Minotaur Acher", "Minotaur Guard", "Minotaur Mage", "Minotaur", "Mummy", "Necromancer", "Necropharus", "Orc Berserker", "Orc Leader", "Orc Shaman", "Orc Spearman", "Orc Warlord", "Orc Warrior", "Orc", "Parrot", "Pig", "Poison Spider", "Priestess", "Butterfly", "Rabbit", "Rat", "RotWorm", "Scarab", "Scorpion", "Sheep", "Skeleton", "Skunk", "Slime", "Snake", "Spider", "Swamp Troll", "The Halloween Hare", "The Horned Fox", "Troll", "Vampire", "Wasp", "Winter Wolf", "Wolf",
        ];

        $creaturesAlign5 = [

            "Frost Dragon", "Frozemoth"
        ];

        $style= "position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);";

        if(in_array($creatureName, $creaturesAlign)){
            $style = "position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); width: 100%";
        }

        $monsterDeleted = [

            "Flamethrower", "Magicthrower", "Plaguethrower", "Shredderthrower", "Grinch", "Evil Grinch", "Gamemaster", "Dummy Target", "Fury", "Dummy Target Ravenor", "Pumpkinhead", "Novice Pumpkinhead", "Dummy Elite", "Bring Me The Halloween"
        ];


    @endphp

    <div>
        <div style="display: inline-block; position: relative;">
            <span style="position: absolute; left: 7px; top: 50%; transform: translateY(-50%);">
                <img src="/images/ser1.png" alt="Ícone de Pesquisa" style="width: 20px; height: 20px;">
            </span>
            <input id="search_creature" type="text" class="item_search_input" name="search_creature" value="" placeholder="Search Monster.." style="padding-left: 30px;">
        </div>
    </div>

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

    <div id="monsterSearch" style="display: none;">
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
                        <td><div class="TableContentContainer" style="display: none">
                            <table id="tableContainer" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                            <tbody>
                                @php $columnCount = 0; @endphp
                                @foreach ($creatures as $index => $creature)
                                    @php

                                        if(in_array($creature["name"], $monsterDeleted)){
                                            continue;
                                        }
                        
                                        $formattedCreature = str_replace(' ', '', strtolower($creature["name"]));
                                        $creatureName = $creature["name"];
                                        $creatureId = $creature["type"];
                        
                                        if(in_array($creatureName, $creaturesAlign)){
                                            $style = "position: absolute; left: 23px; top: 0px";
                                        } elseif(in_array($creatureName, $creaturesAlign1)){
                                            $style = "position: absolute; left: 28px; top: 2px";
                                        } elseif(in_array($creatureName, $creaturesAlign2)){
                                            $style = "position: absolute; left: 38px; top: 5px;";
                                        } elseif(in_array($creatureName, $creaturesAlign3)){
                                            $style = "position: absolute; left: 30px; top: -10px";
                                        } elseif(in_array($creatureName, $creaturesAlign4)){
                                            $style = "position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);";
                                        } elseif(in_array($creatureName, $creaturesAlign5)){
                                            $style = "position: absolute; left: 40%; top: 30%; transform: translate(-50%, -50%); width: 90px";
                                        } else {
                                            $style = "position: absolute; left: 50%; top: 35%; transform: translate(-50%, -50%)";
                                        }
                        
                                        if(array_key_exists($creatureName, $creaturesOutfit)){
                                            $creatureAddon = $creaturesOutfit[$creatureName]["addons"];
                                            $creatureHead = $creaturesOutfit[$creatureName]["head"];
                                            $creatureBody = $creaturesOutfit[$creatureName]["body"];
                                            $creatureLeg = $creaturesOutfit[$creatureName]["legs"];
                                            $creatureFeet = $creaturesOutfit[$creatureName]["feet"];
                                            $creatureSrc = "$serverPath/outfits/animoutfit.php?id=$creatureId&addons=$creatureAddon&head=$creatureHead&body=$creatureBody&legs=$creatureLeg&feet=$creatureFeet";
                                        } else {
                                            $creatureSrc = "$serverPath/outfits/animoutfit.php?id=$creatureId.gif?v=1";
                                        }
                        
                                    @endphp
                        
                                    @if ($columnCount % 5 == 0)
                                        <tr>
                                    @endif
                        
                                    <td id="{{ $creatureName }}" class="monster" style="border: 2px solid rgba(121, 61, 3, 0.65); border-radius: 10px; background-color: rgba(255, 255, 255, 0.46); box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">
                                        <br>
                        
                                        <div onclick="fillCreatureTable('{{ $creatureName }}')" style="cursor: pointer;">
                                            <div class="creatureListBoxNew">
                                                <img style="{{ $style }};" src="{{ $creatureSrc }}"/>
                                                <label style="position: absolute; left: 50%; top: 90%; transform: translate(-50%, -50%); width: 100px">{{ $creatureName }}</label>
                                            </div>
                                        </div>
                        
                                        <br>
                                    </td>
                        
                                    @php $columnCount++; @endphp
                        
                                    @if (($columnCount) % 5 == 0 || $loop->last)
                                        </tr> 
                                    @endif
                                @endforeach
                            </tbody>
                            </table>
                        </div></td>
                    </tr>
                    </tbody>
                </table>
                </div></td>
            </tr>
        </tbody>
        </table>
    </div>

    <style>

        #monsterSearch {
            overflow: hidden;
            width: 100%;
        }

        #monsterScroller {
            display: flex;
            white-space: nowrap;
            animation: marquee 10s linear infinite;
        }

        #monsterScroller .monster {
            flex: 0 0 auto;
            margin-right: 10px;
        }

        @keyframes marquee {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        #monsterSearch {
            width: 750px;         
            overflow: hidden;
            margin: 0 auto;        
        }

        #monsterTicker {
            display: flex;
            flex-wrap: nowrap;
        }

        .monster-wrapper {
            width: 150px; 
            margin-right: -40px; 
            border: 2px solid rgba(121, 61, 3, 0.65);
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.46);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            flex-shrink: 0; 
            scale: 0.7
        }

    </style>

    <script src="{{ asset('assets/tibiarl/js/about/wiki/creaturesViewFlow.min.js') }}?v=2" defer></script>
    
    @php
        $creaturesJson = json_encode($creatures);
    @endphp

    <div id="creaturesData" data-creatures='<?php echo htmlspecialchars($creaturesJson); ?>'></div>

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
                <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span>
                <span class="CaptionVerticalLeft" style="background-image:url(assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
                <div class="Text">Creature</div>
                <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
                <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
            </div>
        </div>
        <table class="Table3" cellpadding="0" cellspacing="0">
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
                                            <tbody id="creatureDataBody">
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
                        <table style="width:100%;">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="TableContentContainer">
                                            <table id="correctColors" class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                <tbody>

                                                    <tr class="Odd">
                                                        <td class="LabelV175">Health:</td>
                                                        <td id="health">
                                                            <img src="/images/tbIcons/hearthp.png" style="vertical-align: middle;">
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr class="Even">
                                                        <td class="LabelV175">Experience:</td>
                                                        <td id="experience">
                                                            <img src="/images/tbIcons/experience.png" style="vertical-align: middle;">
                                                        </td>
                                                    </tr>

                                                    <tr class="Even">
                                                        <td class="LabelV175">Est. Max Dmg:</td>
                                                        <td id="maxDmg">
                                                            <small>Total: / </small>
                                                        </td>
                                                    </tr>

                                                    <tr class="Odd">
                                                        <td class="LabelV175">Summonable:</td>
                                                        <td id="summonable">
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr class="Even" id="convinceableRow">
                                                        <td class="LabelV175">Convinceable:</td>
                                                        <td id="convinceable">
                                                        </td>
                                                    </tr>

                                                    <tr class="Odd" id="manaCostRow" style="display: none;">
                                                        <td class="LabelV175">Mana Cost:</td>
                                                        <td id="manaCost">
                                                        </td>
                                                    </tr>

                                                    <tr class="Even">
                                                        <td class="LabelV175">Sounds:</td>
                                                        <td id="sounds" style="padding: 10px; color: rgb(243, 100, 5); font-weight: bold">
                                                        </td>
                                                    </tr>
                    
                                                    <tr class="Odd">
                                                        <td class="LabelV175">Abilities:</td>
                                                        <td id="abilities" style="padding: 10px">                                                  
                                                        </td>
                                                    </tr>
                                                                        
                                                    <tr class="Even">
                                                        <td class="LabelV175">Immunities:</td>
                                                        <td id="immunities" style="padding: 10px">
                                                        </td>
                                                    </tr>                                                    

                                                    <tr class="Odd">
                                                        <td class="LabelV175">Avg NPC Loot Value:</td>
                                                        <td>?</td>
                                                        {{-- <span style="color: #775700;">{{ $creatures[$allMonsterData[$creature_name]]["avg_npc_loot_value"] }}</span> --}}
                                                    </tr>

                                    

                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="TableContentContainer">
                                            <table class="TableContent">
                                                <tbody id="lootTable">
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
    </div>

    <style>

        #HelperDivContainer {
            display: none;
            position: absolute;
            width: 225px;
            z-index: 1000;
            color: #5a2800;
            font-family: Verdana,Arial,Times New Roman,sans-serif;
            font-size: 9pt;
            text-align: left;
            padding: 10px;
            border: 1px double #5a2800;
            margin-left: 8px;
        }

        #HelperDivContainer .HelperDivArrow {
            position: absolute;
            top: -1px;
            left: -8px;
            width: 8px;
            height: 13px;
        }

        #HelperDivContainer {
            color: #5a2800;
            font-family: Verdana,Arial,Times New Roman,sans-serif;
            font-size: 9pt;
            text-align: left;
        }

        #HelperDivContainer #HelperDivHeadline {
            position: relative;
            white-space: normal;
            margin-top: 0;
            margin-bottom: 15px;
        }

        #HelperDivContainer #HelperDivHeadline {
            font-size: 12pt;
            font-weight: 700;
        }

        #HelperDivContainer {
            color: #5a2800;
            font-family: Verdana,Arial,Times New Roman,sans-serif;
            font-size: 9pt;
            text-align: left;
        }

        #HelperDivContainer {
            color: #5a2800;
            font-family: Verdana,Arial,Times New Roman,sans-serif;
            font-size: 9pt;
            text-align: left;
        }

        .itemImg {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            text-align: center;
        }

    </style>

    <div id="HelperDivContainer" style="background-image: url(&quot;/assets/tibiarl/images/content/scroll.gif&quot;); display: none;">
        <div class="HelperDivArrow" style="background-image: url(&quot;/assets/tibiarl/images/content/helper-div-arrow.png&quot;); top: -1px;"></div>
        <div id="HelperDivHeadline">Use instant travel system</div>
        <div id="HelperDivText">No matter where you are heading, travel via the Ravenor transport system and you will always be there in a jiffy! Boats, magic carpets, steamships, astral bridges, elemental shrines - travelling has never been that convenient.</div>
        <center>
            <img class="Ornament" src="/assets/tibiarl/images/content/ornament.gif">
        </center>
        <br>
    </div>

    <br>

    <center>
        <div class="BigButton" style="background-image:url(https://ravenor.online/assets/tibiarl/images/buttons/sbutton.gif)" onclick="javascript:history.go(-1)">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url(&quot;https://ravenor.online/assets/tibiarl/images/buttons/sbutton_over.gif&quot;); visibility: hidden;"></div>
                <input class="BigButtonText" type="submit" value="Back">
            </div>
        </div>
    </center>

    <link rel="stylesheet" href="{{ asset('assets/tibiarl/css/about/wiki/creaturesView.css') }}?v=1">
    <script> const creatureName = "<?php echo $name; ?>"; </script>
    <script src="{{ asset('assets/tibiarl/js/about/wiki/creaturesView.min.js') }}?v=17a" defer></script>

@endsection
