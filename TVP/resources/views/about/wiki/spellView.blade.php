@extends('template.layout')
@section('title', ucwords(urldecode($name)) . ' Wiki')
@section('submenuItem', 'spells')
@section('content')

    @php

        include "./spells.php"; 
        include "./npcs.php";

        function findSpellByName($spells, $name, $runas) {

            $cleanName = trim(urldecode($name));

            foreach ($spells as $spell) {

                if (strcasecmp(strtolower($spell['name']), strtolower($cleanName)) === 0) {
                    return $spell;
                }
            }

            foreach ($spells as $spell) {

                if (strcasecmp($spell['words'], $cleanName) === 0) {
                    return $spell;
                }
            }

            return null;
        }

        //$name = str_ireplace('rune', '', $name);

        $spellFound = findSpellByName($spells, urldecode($name), $runas);
        $jsonData = json_decode(file_get_contents('runes_data.json'), true);

        if ($spellFound && isset($spellFound['category'])) {

            if ($spellFound['category'] == 'rune') {


                if (isset($runas[$spellFound['words']][0])) {

                    $spellName = trim($runas[$spellFound['words']][0]);
                    $name_search = trim(str_replace("Rune", "", $spellName)) . " Rune";

                } else {
                  
                    $name_search = 'Unknown Rune';
                }

            } else {
                $name_search = trim($spellFound["name"]);
            }

        } else {

            $name_search = 'Spell not found';
        }

        $spellData = collect($jsonData)->firstWhere('name', $spellFound["name"]);

        $npcs_buying = [];
        $npcs_selling = [];

        $name_search = trim(str_ireplace('rune', '', $name_search));

        foreach ($npcs as $npc) {

            foreach ($npc['buy'] as $buy_item) {

                if ($buy_item['name'] == $spellFound["name"]) {

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

    @endphp

    <style>

        .sellerRow {
            border: 1px solid #faf0d7;
            background-color: hsla(0,0%,100%,.46);
            box-shadow: 0 0 10px rgba(0,0,0,.5);
            padding-left: 5px;
            padding-top: 2px;
            padding-right: 5px;
            padding-bottom: 2px;
        }

        .LabelV175{

            width: 100px !important;
        }

    </style>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
            <tr>
                <td>
                    @if($spellFound && isset($spellFound['category']) && $spellFound['category'] == 'rune')
                        <img src="/images/rune_images/{{ str_replace(' ', '_', $spellFound["name"]) }}{{ $spellFound['category'] == 'rune' && !str_contains(strtolower($spellFound["name"]), 'rune') ? '_Rune' : '' }}.png?v=2"
                            alt="Spell Image"
                            onerror="this.style.display='none'; this.insertAdjacentHTML('afterend', '❓');" />
                    @else
                        <img src="/images/rune_images/{{ str_replace(' ', '_', optional($spellFound)['name'] ?? '') }}{{ optional($spellFound)['category'] == 'rune' && !str_contains(strtolower(optional($spellFound)['name'] ?? ''), 'rune') ? '_Rune' : '' }}.png?v=2"
                        alt="Spell Image"
                        onerror="this.style.display='none'; this.insertAdjacentHTML('afterend', '❓');" />                   
                    @endif
                </td>                
                
                <td width="90%">
                    <h2 style="text-align: center">

                        @if($spellFound && isset($spellFound['category']) && $spellFound['category'] == 'rune')

                            {{ $spellFound["name"] }} 

                            @if(!str_contains(strtolower($spellFound["name"]), 'rune'))
                                Rune
                            @endif

                        @else
                            @if($spellFound)
                                {{ $spellFound["name"] }} 
                            @endif
                        @endif
                    </h2>
                </td>

                <td>
                    @if($spellFound && isset($spellFound['category']) && $spellFound['category'] == 'rune')
                        <img src="/images/rune_images/{{ str_replace(' ', '_', $spellFound["name"]) }}{{ $spellFound['category'] == 'rune' && !str_contains(strtolower($spellFound["name"]), 'rune') ? '_Rune' : '' }}.png?v=2"
                            alt="Spell Image"
                            onerror="this.style.display='none'; this.insertAdjacentHTML('afterend', '❓');" />
                    @else
                        <img src="/images/rune_images/{{ str_replace(' ', '_', $spellFound['name']) }}{{ $spellFound['category'] == 'rune' && !str_contains(strtolower($spellFound['name']), 'rune') ? '_Rune' : '' }}.png?v=2"
                            alt="Spell Image"
                            onerror="this.style.display='none'; this.insertAdjacentHTML('afterend', '❓');" />
                    @endif
                </td>                  
            </tr>
        </tbody>
    
    </table>

    <br>

    @php
        $description = $spellData['description'] ?? 'Descrição não disponível.';
        $spellName = $spellFound['name'] ?? '';

        if (strpos($description, $spellName) === 0) {
            $description = substr($description, strlen($spellName));
        }

    @endphp

    {!! ucfirst($description ?? 'Descrição não disponível.') !!}

    <br><br><br>

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
                <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span>
                <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
                <div class="Text">Spell Information</div>
                <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
                <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
            </div>
        </div>
    
        <table class="Table2" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td>
                        <div class="InnerTableContainer" style="max-width: unset;">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="TableContentContainer">
                                                <table class="TableContent" width="100%" style="border: 1px solid #faf0d7;">
                                                    <tbody>
                                                        <tr bgcolor="#D4C0A1">
                                                            <td class="LabelV175" width="15%">Name:</td>
                                                                <td>
                                                                    @if($spellFound['category'] == 'rune')
                                                                        <a href="/about/itemPage/{{ urlencode($spellFound['name']) }}{{ $spellFound['category'] == 'rune' && !str_contains(strtolower($spellFound['name']), 'rune') ? '+Rune' : '' }}">
                                                                            {{ $spellFound['name'] }} 
                                                                        
                                                                            @if($spellFound["category"] == 'rune' && !str_contains(strtolower($spellFound['name']), 'rune'))
                                                                                Rune
                                                                            @endif
                                                                        </a>   
                                                                    @else
                                                                        {{ $spellFound["name"] }} 
                                                                    @endif
                                                                </td>
                                                            </td>
                                                        </tr>
                                                        <tr bgcolor="#F1E0C6">
                                                            <td width="15%" class="LabelV175">Formula:</td>
                                                            <td>{{ $spellFound["words"]  }}</td>
                                                        </tr>

                                                        <tr bgcolor="#D4C0A1">
                                                            <td class="LabelV175">Vocation:</td>
                                                            <td>
                                                                @foreach ($spellFound["vocation"] as $vocation)
                                                                    {{ $vocation }}@if (!$loop->last), @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>

                                                        <tr bgcolor="#F1E0C6">
                                                            <td class="LabelV175">Group:</td>
                                                            <td>
                                                                {{ isset($runas[$spellFound["words"]][1]) ? $runas[$spellFound["words"]][1] : 'Not found.' }}
                                                            </td>                                                            
                                                        </tr>

                                                        <tr bgcolor="#D4C0A1">
                                                            <td class="LabelV175">Type:</td>
                                                            <td>{{ ucwords($spellFound["category"]) }}</td>
                                                        </tr>

                                                        @if(isset($spellFound["conjureAmount"]))
                                                                
                                                            <tr bgcolor="#F1E0C6">
                                                                <td class="LabelV175">Amount Receive:</td>
                                                                <td>{{ $spellFound["conjureAmount"] }}</td>
                                                            </tr>
                                                            
                                                        @endif

                                                        <tr bgcolor="#F1E0C6">
                                                            <td class="LabelV175">Mana:</td>
                                                            <td>
                                                                @if(isset($spellFound["mana"]))
                                                                    {{ ucwords($spellFound["mana"]) }}
                                                                @else
                                                                    {{ ucwords($spellFound["manaPercent"]) }}
                                                                @endif
                                                            </td>
                                                            
                                                        </tr>

                                                        <tr bgcolor="#D4C0A1">
                                                            <td class="LabelV175">Mag Lvl:</td>
                                                            <td>{{ $spellFound["magicLevel"] }}</td>                                                          
                                                        </tr>


                                                        @if(isset($spellFound["charges"]))
                                                            <tr bgcolor="#F1E0C6">
                                                                <td class="LabelV175">Charges:</td>
                                                                <td>{{ $spellFound["charges"] }}</td>
                                                            </tr>

                                                            <tr bgcolor="#D4C0A1">
                                                                <td class="LabelV175">Price:</td>
                                                                <td>{{ isset($npcs_buying[0]['price']) ? $npcs_buying[0]['price'] : 0 }}</td>
                                                            </tr>


                                                            <tr bgcolor="#F1E0C6">
                                                                <td class="LabelV175">Premium:</td>
                                                                <td>
                                                                    @if(isset($spellFound["isPremium"]))
                                                                        <img src="/assets/tibiarl/images/premiumfeatures/icon_yes.png">
                                                                    @else
                                                                        <img src="/assets/tibiarl/images/premiumfeatures/icon_no.png">
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                        @else
                                                           
                                                            <tr bgcolor="#F1E0C6">
                                                                <td class="LabelV175">Premium:</td>
                                                                <td>
                                                                    @if(isset($spellFound["isPremium"]))
                                                                        <img src="/assets/tibiarl/images/premiumfeatures/icon_yes.png">
                                                                    @else
                                                                        <img src="/assets/tibiarl/images/premiumfeatures/icon_no.png">
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif

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
    
    @if($spellFound["category"] == "rune")

        <br>

        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
                    <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
                    <div class="Text">Rune Information</div>
                    <span class="CaptionVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
                    <span class="CaptionBorderBottom" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span>
                    <span class="CaptionEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
                    <span class="CaptionEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
                </div>
            </div>
        
            <table class="Table2" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td>
                            <div class="InnerTableContainer" style="max-width: unset;">
                                <table style="width: 100%;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="TableContentContainer">
                                                    <table class="TableContent" width="100%" style="border: 1px solid #faf0d7;">
                                                        <tbody>
                                                            <tr bgcolor="#D4C0A1">
                                                                <td width="15%">Name:</td>
                                                                <td>
                                                                    @if($spellFound['category'] == 'rune')
                                                                        <a href="/about/itemPage/{{ urlencode($spellFound["name"]) }}{{ $spellFound['category'] == 'rune' && !str_contains(strtolower($spellFound["name"]), 'rune') ? '+Rune' : '' }}">
                                                                            {{ $spellFound["name"] }} 
                                                                        
                                                                            @if($spellFound["category"] == 'rune' && !str_contains(strtolower($spellFound["name"]), 'rune'))
                                                                                Rune
                                                                            @endif
                                                                        </a>   
                                                                    @else
                                                                        {{ $spellFound["name"] }} 
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            {{-- <tr bgcolor="#F1E0C6">
                                                                <td>Vocation:</td>
                                                                <td></td>
                                                            </tr> --}}
                                                            <tr bgcolor="#F1E0C6">
                                                                <td>Group:</td>
                                                                <td>
                                                                    {{ isset($runas[$spellFound["words"]][1]) ? $runas[$spellFound["words"]][1] : 'Not found.' }}
                                                                </td> 
                                                            </tr>
                                                            <tr bgcolor="#D4C0A1">
                                                                <td>Mag Lvl:</td>
                                                                <td>{{ $spellFound["runeMagicLevel"] }}</td>
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
                </tbody>
            </table>
        </div>

    @endif    

    <br>

    <div style="width: 48%">
        <h3>Spell Offers</h3>

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 5px;">NPC</th>
                    <th style="text-align: left; padding: 5px;">Location</th>
                    <th style="text-align: left; padding: 5px;">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($npcs_buying) > 0): ?>
                    <?php foreach ($npcs_buying as $npc) : ?>
                        <tr>
                            @php
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

                            <td class="sellerRow">
                                <a href="{{ route('about.npcsView', ['name' => $npc['name']]) }}#{{ $adjustedPositionString }}:{{ $zoom }}">
                                    <span>{{ $npc['name'] }}</span>
                                </a>
                            </td>
                            <td class="sellerRow">{{ $npc['location'] }}</td>
                            <td class="sellerRow" style="padding: 5px;">
                                {{ $npc['price'] }} gold
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 10px;">No offers available</td>
                    </tr>
                <?php endif; ?>
            </tbody>            
        </table>

    </div>

    <br><br>

    <br>

    <center>
        <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton.gif)" 
             onclick="handleBackButtonClick()">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                <div class="BigButtonOver" style="background-image: url(/assets/tibiarl/images/buttons/sbutton_over.gif); visibility: hidden;"></div>
                <input class="BigButtonText" type="submit" value="Back">
            </div>
        </div>
    </center>
    
    <script>
        function handleBackButtonClick() {
            if (window.history.length > 1) {
                window.history.go(-1);
            } else {
                window.location.href = '{{ url('/library/spells') }}';
            }
        }
    </script> 
    
@endsection

