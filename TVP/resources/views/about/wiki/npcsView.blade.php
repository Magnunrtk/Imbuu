@extends('template.layout')
@section('title', 'Npcs')
@section('submenuItem', 'npcs')
@section('content')

    @php 
    
        include "./npcs.php"; 
        include "./itemsXml.php";
        include "./spells.php";
        include "./items.php";  

        $creature_name = $name;

        $npcData = null; 

        foreach ($npcs as $key => $npc) {
            if ($npc['name'] === $creature_name) {
                $npcData = $npc;
                break;
            }
        }

        $serverPath = config('server.fullServerDomain');

        $allMonsterData = [];

        foreach ($npcs as $index => $creature) {
            $creatureName = $creature_name;
            $allMonsterData["Ray"] = $creature;
        }

        $formattedName = strtolower(str_replace(' ', '', $name));

        $creaturesOutfit = [];

        $creatureId = $npcData["look"]["type"];
        $creatureName = $npcData["name"];
        $creatureCity = $npcData["location"];

        if($creatureName == "The Gatekeeper" || $creatureName == "The Oracle"){

            $creatureSrc = "/items/2031.gif";

        }elseif($creatureName == "Cobra"){

            $style="transform: rotate(180deg); margin-left: 13px";
            $creatureSrc = "/items/2051.gif";

        }elseif($creatureName == "Frans"){

            $style="transform: rotate(180deg); margin-left: 13px";
            $creatureSrc = "/items/3114.gif";

        }else{

            $creatureAddon = $npcData["look"]["addons"];
            $creatureHead =  $npcData["look"]["head"];
            $creatureBody =  $npcData["look"]["body"];
            $creatureLeg =  $npcData["look"]["legs"];
            $creatureFeet =  $npcData["look"]["feet"];
            $creatureSrc = "/outfits/animoutfit.php?id=$creatureId&addons=$creatureAddon&head=$creatureHead&body=$creatureBody&legs=$creatureLeg&feet=$creatureFeet";
        }        
        
        // var_dump($creatureSrc);

        $numeroTotalCasos = 100000;

        $creaturesAlign = [

            "Frost Dragon"
        ];

        $style= "position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);";

        if(in_array($creatureName, $creaturesAlign)){
            $style = "position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); width: 100%";
        }

    @endphp

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
                <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span>
                <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
                <div class="Text">Npcs</div>
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
                                            <tbody>
                                            <tr class="LabelH">
                                                <td>Image</td>
                                                <td>Name</td>
                                            </tr>

                                            <tr class="Even" style="height: 165px">
                                                <td style="width: 100px; height: 100px; padding: 0;">
                                                    <div style="position: relative; width: 100px; height: 100px;">
                                                        <img src="{{ $creatureSrc }}?v=1" style="{{ $style }};">
                                                    </div>
                                                </td>
                                                
                                                <td style="width: 99%">
                                                    <h1 style="font-family: 'Martel', sans-serif; font-size: 44px; font-weight: normal; height: 25px; margin-bottom: 5px;">{{ $name }}</h1>
                                                    <h2 style="font-family: 'Martel', sans-serif; font-size: 18px; font-weight: bold; color: #bc6600; margin-top: 18; margin-bottom: 0;">{{ $creatureCity }}
                                                    </h2>
  

                                                    <br>
                                                    
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
                        <table style="width:100%;">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="TableContentContainer">
                                            <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                                <tbody>

                                                    <tr>
                                                        <td colspan="2">
                                                            <div style="display: flex; justify-content: space-between;">
                                                                
                                                                <!-- Verifica se há ofertas de compra -->
                                                                @if(count($npcData['sell']) > 0)
                                                                <div style="width: 48%;">
                                                                    <h3>Sell Offers</h3>
                                                                    <table style="width: 100%; border-collapse: collapse;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="text-align: left; padding: 5px;">Item</th>
                                                                                <th style="text-align: left; padding: 5px; height: 30px;">Price</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($npcData['sell'] as $item)
                                                                            <tr>
                                                                                <td style="background-color: hsla(0,0%,100%,.46); box-shadow: 0 0 10px rgba(0,0,0,.5);">
                                                                                    <div style="display: flex; align-items: center;">
                                                                                        <img src="/items/{{ $item['clientId'] }}.gif?v=1" style="width: 20px; margin-right: 8px;">
                                                                                        <a href="/about/itemPage/x?search={{ urlencode(strtolower($item['clientId'])) }}">
                                                                                            @php
                                                                                                foreach ($all_items as $currentItem) {
 
                                                                                                    if (isset($currentItem['attributes']['clientid']) && $currentItem['attributes']['clientid'] == $item['clientId']) {
                                                                                                        
                                                                                                        $itemName = isset($currentItem['name']) ? $currentItem['name'] : 'Nome não encontrado';
                                                                                                        break;
                                                                                                    }
                                                                                                }

                                                                                                if (isset($itemName)) {
                                                                                                    echo "<span>" . ucwords(strtolower($itemName)) . "</span>";
                                                                                                } else {
                                                                                                    echo "<span>Item não encontrado</span>";
                                                                                                }
                                                                                            @endphp
                                                                                        </a>
                                                                                    </div>
                                                                                </td>
                                                    
                                                                                <td style="padding: 5px; background-color: hsla(0,0%,100%,.46); box-shadow: 0 0 10px rgba(0,0,0,.5);">
                                                                                    {{ $item['price'] }} gold
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                @else
                                                                <div style="width: 48%; padding: 10px;">
                                                                    <h3>Sell Offers</h3>
                                                                    <p>No sell offers available.</p>
                                                                </div>
                                                                @endif
                                                                                        
                                                                @if(count($npcData['buy']) > 0)
                                                                <div style="width: 48%;">
                                                                    <h3>Buy Offers</h3>
                                                                    <table style="width: 100%; border-collapse: collapse;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="text-align: left; padding: 5px;">Item</th>
                                                                                <th style="text-align: left; padding: 5px;">Price</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                            @foreach ($npcData['buy'] as $item)
                                                                            <tr>
                                                                                @php
                                                                                    $runeTag = '';
                                                                                    $imageTag = $item['name'];
                                                                                    $runeName = ''; 

                                                                                    $filteredSpells = array_filter($spells, function ($spell) use ($item) {
                                                                                        return $spell['name'] === $item['name'];
                                                                                    });
                                                                                
                                                                                    if (!empty($filteredSpells)) {

                                                                                        $spell = array_values($filteredSpells)[0]; 
                                                                                        $words = strtolower($spell['words']);

                                                                                        if ($spell['category'] === 'rune') {
                                                                                            $runeTag = '_Rune';
                                                                                        }
                                                                                    }
                                                                                @endphp

                                                                                @if(!empty($filteredSpells))

                                                                                    <td style="	background-color: hsla(0,0%,100%,.46); box-shadow: 0 0 10px rgba(0,0,0,.5);">
                                                                                        <div style="display: flex; align-items: center;">

                                                                                            @if (isset($item['class']))

                                                                                                @php
                                                                                                    $relatedItem = null;
                                                                                                    foreach ($all_items as $allItem) {
                                                                                                        if ($allItem['id'] == $item['type']) {
                                                                                                            $relatedItem = $allItem;
                                                                                                            break;
                                                                                                        }
                                                                                                    }

                                                                                                    $clientId = $relatedItem ? $relatedItem['attributes']['clientid'] : null;
                                                                                                @endphp
                                                                                                
                                                                                                @if ($clientId)
                                                                                                    <img src="{{ asset('items/' . $clientId . '.gif') }}?v=1" style="width: 20px; margin-right: 8px;">
                                                                                                @else
                                                                                                    <img src="{{ asset('items/default.gif') }}?v=1" style="width: 20px; margin-right: 8px;">
                                                                                                @endif

                                                                                                <a href="/about/itemPage/{{ urlencode(strtolower($item['name'])) }}?code={{ $item['type'] }}">
                                                                                                    <span>{{ ucwords(strtolower($relatedItem['name'])) }}</span>
                                                                                                </a>

                                                                                            @elseif (isset($item['clientId']))
                                                                                                <img src="{{ asset('items/' . $item['clientId'] . '.gif') }}?v=1" style="width: 20px; margin-right: 8px;">
                                                                                                
                                                                                                <a href="/about/itemPage/{{ urlencode(strtolower($item['name'])) }}">
                                                                                                    <span>{{ ucwords(strtolower($item['name'])) }}</span>
                                                                                                </a>
                                                                                            @else

                                                                                                @php
                                                                                                    $baseName = $spell['name'];

                                                                                                    if (!str_contains($baseName, 'Rune')) {
                                                                                                        $baseName .= $runeTag; 
                                                                                                    }

                                                                                                    $imageName = str_replace(' ', '_', $baseName);
                                                                                                @endphp

                                                                                                <img src="{{ asset('images/rune_images/' . $imageName . '.png') }}?v=2" style="width: 20px; margin-right: 8px;">

                                                                                                <a href="/about/spellView/{{ $spell['name'] }}">
                                                                                                    <span>{{ ucwords(strtolower($item['name'])) }}</span>
                                                                                                </a>

                                                                                            @endif

                                                                                        </div>
                                                                                    </td>

                                                                                @else

                                                                                    @php 
                                                                                    
                                                                                        $relatedItem = null;
                                                                                        foreach ($all_items as $allItem) {
                                                                                            if ($allItem['id'] == $item['type']) {
                                                                                                $relatedItem = $allItem;
                                                                                                break;
                                                                                            }
                                                                                        }

                                                                                        $clientId = $relatedItem ? $relatedItem['attributes']['clientid'] : null;

                                                                                    @endphp

                                                                                    <td style="background-color: hsla(0,0%,100%,.46); box-shadow: 0 0 10px rgba(0,0,0,.5);">
                                                                                        <div style="display: flex; align-items: center;">
                                                                                            <img src="{{ asset('items/' . $clientId . '.gif') }}?v=1" style="width: 20px; margin-right: 8px;">
                                                                                    
                                                                                            <a href="/about/itemPage/{{ urlencode(strtolower($item['name'])) }}">
                                                                                                <span>{{ ucwords(strtolower($item['name'])) }}</span>
                                                                                            </a>
                                                                                        </div>
                                                                                    </td>

                                                                                @endif

                                                    
                                                                                <td style="padding: 5px; background-color: hsla(0,0%,100%,.46); box-shadow: 0 0 10px rgba(0,0,0,.5);">
                                                                                    {{ $item['price'] }} gold
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                @else
                                                                <div style="width: 48%; padding: 10px;">
                                                                    <h3>Buy Offers</h3>
                                                                    <p>No sell offers available.</p>
                                                                </div>
                                                                @endif
                                                    
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
                </td>
            </tr>

            </tbody>
        </table>
    </div>
    
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
        <div class="BigButton" style="background-image:url(/assets/tibiarl/images/buttons/sbutton.gif)" 
             onclick="handleBackButtonClick()">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
                <div class="BigButtonOver" style="background-image: url('/assets/tibiarl/images/buttons/sbutton_over.gif'); visibility: hidden;"></div>
                <input class="BigButtonText" type="submit" value="Back">
            </div>
        </div>
    </center>
    
    <script>

        const originalReferrer = document.referrer;
    
        function isValidReferrer(referrer) {
            return referrer && referrer !== window.location.href && !referrer.includes('#');
        }
    
        function handleBackButtonClick() {
            if (isValidReferrer(originalReferrer)) {
                window.location.href = originalReferrer;
            } else if (window.history.length > 1) {
                window.history.go(-1);
            } else {
                window.location.href = '{{ url('/library/spells') }}';
            }
        }
    </script>

    <link rel="stylesheet" href="{{ asset('assets/tibiarl/css/about/wiki/creaturesView.css') }}?v=1">

    {{-- <script src="{{ asset('assets/tibiarl/js/about/wiki/creaturesView.js') }}?v=1" defer></script> --}}

@endsection

