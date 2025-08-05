@extends('template.layout')
@section('title', 'NPCs')
@section('submenuItem', 'npcs')
@section('content')

@php 

    include './npcs.php';

    $creaturesAlign = ["Ursula", "Halloween Undead"];
    $creaturesAlign1 = [];
    $creaturesAlign2 = ["Ancient Scarab", "Crystal Spider", "Grorlam", "The Old Widow"];
    $creaturesAlign3 = [];
    $creaturesAlign4 = ["Rata'mari", "Noodles", "Lightfoot", "Puffels", "Basilisk", "Dustrunner", "Smiley", "Avar Tar", "Vladruc", "Sigurd"];
    $creaturesAlign5 = ["Frost Dragon", "Frozemoth"];
    $creaturesOutfit = [];
    $monsterDeleted = ["Flamethrower", "Magicthrower", "Plaguethrower", "Shredderthrower", "Grinch", "Evil Grinch", "Gamemaster", "Dummy Target", "Fury", "Dummy Target Ravenor", "Pumpkinhead", "Novice Pumpkinhead", "Dummy Elite"];

@endphp

<style>
    .creatureListBox {
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

    select{
        background-color: white;
    }

</style>

<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">Npc Search</div>
            <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
        </div>
    </div>
    <table class="Table2" cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <td>
                <div class="InnerTableContainer" style="max-width: unset;">
                    <table style="width:100%;">
                        <tbody>
                        <tr>
                            <td>
                                <div class="TableContentContainer">
                                    <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                        <tbody>
                                        <tr bgcolor="#D4C0A1">
                                            <td width="20%"><b>Search by name:</b></td>
                                            <td width="20%"><b>Vocation:</b></td>
                                            <td width="20%"><b>City:</b></td>
                                            <td width="20%"><b>Premium:</b></td>
                                        </tr>
                                        <tr bgcolor="#D4C0A1">

                                            <td>
                                                <div>
                                                    <div style="display: inline-block; position: relative;">
                                                        <span style="position: absolute; left: 7px; top: 50%; transform: translateY(-50%);">
                                                            <img src="/images/ser1.png" alt="Ícone de Pesquisa" style="width: 20px; height: 20px;">
                                                        </span>
                                                        <input id="search_creature" type="text" class="item_search_input" name="search_creature" value="" placeholder="Search Npcs.." style="padding-left: 30px;"  autocomplete="off">
                                                    </div>
                                                </div>
                                            </td>

                                            <td valign="top">
                                                <select name="profession" id="profession" autocomplete="off">>
                                                    <option value="all">All</option>
                                                    @foreach (['Sorcerer', 'Druid', 'Paladin', 'Knight'] as $vocation)
                                                        <option value="{{ strtolower(str_replace(' ', ' ', $vocation)) }}">{{ $vocation }}</option>
                                                    @endforeach
                                                </select>
                                            </td>                                                
                                            
                                            <td valign="top">
                                                <select name="city" id="city"  autocomplete="off">>
                                                    <option value="all">All</option>
                                                    @foreach (['Thais', 'Carlin', 'Kazzordoon', 'Ab\'dendriel', 'Edron', 'Darashia', 'Venore', 'Ankrahmun', 'Port Hope', 'Isvold'] as $city)
                                                        <option value="{{ strtolower($city) }}">{{ $city }}</option>
                                                    @endforeach
                                                </select>
                                            </td>                                            
                                            
                                            <td valign="top">
                                                <select name="premium" id="premium"  autocomplete="off">>
                                                    <option value="all">All</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </td>

                                        </tr>
                                        <tr></tr>
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
    .item_search_input {
        transition: box-shadow 0.3s ease;
    }

    .item_search_input:hover {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); 
    }
</style>

<br>

<div class="TableContainer">
    <div class="CaptionContainer">
    <div class="CaptionInnerContainer"> <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span> <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span> <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
        <div class="Text">Npcs  <span id="totalNpcs" style="float: right; margin-right: 5px">Total found: {{ count($npcs) }}</span></div>
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
                        <tbody>
                            @php 
                                $columnCount = 0; 

                                usort($npcs, function ($a, $b) {
                                    return strcmp($a['name'], $b['name']);
                                });
                            @endphp

                            @foreach ($npcs as $index => $creature)
                                @php

                                    if(in_array($creature["name"], $monsterDeleted)){
                                        continue;
                                    }
                    
                                    $formattedCreature = str_replace(' ', '', strtolower($creature["name"]));
                                    $creatureName = $creature["name"];
                                    $creatureId = $creature["look"]["type"];

                                    $professions = [];

                                    $hasProfessions = false;

                                    foreach ($creature['buy'] as $item) {

                                        if (isset($item['profession']) && !empty($item['profession'])) {
                                            $professions = array_merge($professions, $item['profession']);
                                            $hasProfessions = true; 
                                        }
                                    }

                                    if (!$hasProfessions) {
                                        $professions[] = "all";
                                    }

                                    $professions = array_unique($professions);
                    
                                    if(in_array($creatureName, $creaturesAlign) || $creature["look"]["type"] == "130" || $creature["look"]["type"] == "57" || $creature["look"]["type"] == "129" || $creature["look"]["type"] == "138" || $creature["look"]["type"] == "136" || $creature["look"]["type"] == "54" || $creature["look"]["type"] == "137" || $creature["look"]["type"] == "128" || $creature["look"]["type"] == "133" || $creature["look"]["type"] == "132" || $creature["look"]["type"] == "146" || $creature["look"]["type"] == "142"){
                                        $style = "position: absolute; left: 23px; top: 0px";
                                    } elseif(in_array($creatureName, $creaturesAlign1) || $creature["look"]["type"] == "117"){
                                        $style = "position: absolute; left: 28px; top: 2px";
                                    } elseif(in_array($creatureName, $creaturesAlign2)){
                                        $style = "position: absolute; left: 38px; top: 5px;";
                                    } elseif(in_array($creatureName, $creaturesAlign3)){
                                        $style = "position: absolute; left: 30px; top: -10px";
                                    } elseif(in_array($creatureName, $creaturesAlign4) || $creature["look"]["type"] == "160" || $creature["look"]["type"] == "9" || $creature["look"]["type"] == "144" || $creature["look"]["type"] == "66" || $creature["look"]["type"] == "5" || $creature["look"]["type"] == "73" || $creature["look"]["type"] == "63" || $creature["look"]["type"] == "48" || $creature["look"]["type"] == "23" || $creature["look"]["type"] == "78" || $creature["look"]["type"] == "70" || $creature["look"]["type"] == "65" || $creature["look"]["type"] == "71" || $creature["look"]["type"] == "64" || $creature["look"]["type"] == "18" || $creature["look"]["type"] == "19" || $creature["look"]["type"] == "37"){
                                        $style = "position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);";
                                    } elseif(in_array($creatureName, $creaturesAlign5)){
                                        $style = "position: absolute; left: 40%; top: 30%; transform: translate(-50%, -50%); width: 90px";
                                    } else {

                                        if (isset($creature["look"]["head"]) && $creature["look"]["head"] == "0") {

                                            $style = "position: absolute; left: 50%; top: 35%; transform: translate(-50%, -50%)";
                                        }else{

                                            $style= "position: absolute; left: 23px; top: 0px";
                                        }

                                        // $style = "position: absolute; left: 50%; top: 35%; transform: translate(-50%, -50%)";
                                    }
                    
                                    if($creatureName == "The Gatekeeper" || $creatureName == "The Oracle"){

                                        $creatureSrc = "/items/2031.gif";
                                        
                                    }elseif($creatureName == "Cobra"){

                                        $style="transform: rotate(180deg); margin-left: 13px";
                                        $creatureSrc = "/items/2051.gif";

                                    }elseif($creatureName == "Frans"){

                                        $style="margin-left: 13px";
                                        $creatureSrc = "/items/3114.gif";

                                    }else{

                                        $creatureAddon = $creature["look"]["addons"];
                                        $creatureHead = $creature["look"]["head"];
                                        $creatureBody = $creature["look"]["body"];
                                        $creatureLeg = $creature["look"]["legs"];
                                        $creatureFeet = $creature["look"]["feet"];
                                        $creatureSrc = "/outfits/animoutfit.php?id=$creatureId&addons=$creatureAddon&head=$creatureHead&body=$creatureBody&legs=$creatureLeg&feet=$creatureFeet";
                                    }                               
                    
                                @endphp
                    
                                @if ($columnCount % 5 == 0)
                                    <tr>
                                @endif
                    
                                <td 
                                data-location="{{ strtolower($creature['location']) }}" 
                                data-professions="{{ isset($professions) && !empty($professions) ? implode(',', $professions) : 'all' }}" 
                                id="{{ $creatureName }}" 
                                class="monster" 
                                style="border: 2px solid rgba(121, 61, 3, 0.65); border-radius: 10px; background-color: rgba(255, 255, 255, 0.46); box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);">

                                    <br>

                                    @php
                                        $npc = $creature;

                                        $ponto1 = ['x' => 32073, 'y' => 31323, 'z' => 7];
                                        $ponto2 = ['x' => 32201, 'y' => 31564, 'z' => 7];

                                        $delta = [
                                            'x' => $ponto2['x'] - $ponto1['x'], // 128
                                            'y' => $ponto2['y'] - $ponto1['y'], // 241
                                            'z' => $ponto2['z'] - $ponto1['z'], // 0
                                        ];

                                        $npcPosition = "{$npc['position'][0]},{$npc['position'][1]},{$npc['position'][2]}";

                                        $adjustedPosition = [
                                            'x' => $npc['position'][0] - $delta['x'],
                                            'y' => $npc['position'][1] - $delta['y'], 
                                            'z' => $npc['position'][2] - $delta['z'], 
                                        ];

                                        $adjustedPositionString = "{$adjustedPosition['x']},{$adjustedPosition['y']},{$adjustedPosition['z']}";

                                        $zoom = 1; 
                                    @endphp
                                    
                                    <a href="{{ route('about.npcsView', ['name' => $creatureName]) }}#{{ $adjustedPositionString }}:{{ $zoom }}" style="font: bold 12px Arial;">
                                        <div class="creatureListBox ">
                                            <img style="{{ $style }};" src="{{ $creatureSrc }}"/>
                                            <label style="position: absolute; left: 50%; top: 90%; transform: translate(-50%, -50%); width: 100px">{{ $creatureName }}</label>
                                        </div>
                                    </a>
                    
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

<br>

<script>
function createTable(e){var t=document.getElementById("tableContainer");t.innerHTML="";for(var n="<table>",o=0;o<e.length;o+=5){n+="<tr>";for(var a=o;a<o+5&&a<e.length;a++)n+='<td style="display:none">'+e[a].outerHTML+"</td>";n+="</tr>"}n+="</table>",t.innerHTML=n}var allMonsters=Array.from(document.querySelectorAll(".monster"));createTable(allMonsters),document.addEventListener("DOMContentLoaded",(function(){const e=document.getElementById("city"),t=document.getElementById("profession"),n=document.getElementById("premium"),o=document.querySelector(".item_search_input"),a=Array.from(document.querySelectorAll(".monster")),r=["edron","darashia","ankrahmun","port hope","isvold"];function l(e){document.getElementById("totalNpcs").textContent="Total found: "+e.length}function s(){const s=e.value.toLowerCase(),d=t.value.toLowerCase(),c=n.value.toLowerCase(),i=o.value.trim().toLowerCase(),u=a.filter((e=>{const t=e.textContent.trim().toLowerCase(),n=e.dataset.location.toLowerCase(),o=e.dataset.professions.toLowerCase().split(","),a=r.includes(n)?"yes":"no",l="all"===s||n===s,u="all"===d||o.includes(d),m="all"===c||"yes"===c&&"yes"===a||"no"===c&&"no"===a,y=!i||t.startsWith(i);return l&&u&&m&&y}));createTable(u),l(u)}e.addEventListener("change",s),t.addEventListener("change",s),n.addEventListener("change",s),o.addEventListener("input",s),createTable(a),l(a)}));
</script>

@endsection

