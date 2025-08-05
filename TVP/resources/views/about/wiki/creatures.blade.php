@extends('template.layout')
@section('title', 'What is ' . config('server.serverName'))
@section('submenuItem', 'creatures')
@section('content')

    @php 

        include './monsterXml.php';

        $creaturesOutfit = [
            "Amazon"        => [ "addons" => 0, "head" => 113, "body" => 120, "legs" => 95,  "feet" => 115 ],
            "Assassin"      => [ "addons" => 0, "head" => 95,  "body" => 95,  "legs" => 95,  "feet" => 95  ],
            "Bandit"        => [ "addons" => 0, "head" => 58,  "body" => 40,  "legs" => 24,  "feet" => 95  ],
            "Ferumbras"     => [ "addons" => 0, "head" => 57,  "body" => 113, "legs" => 95,  "feet" => 113 ],
            "Wild Warrior"  => [ "addons" => 0, "head" => 38,  "body" => 38,  "legs" => 38,  "feet" => 38  ],
            "Black Knight"  => [ "addons" => 0, "head" => 95,  "body" => 95,  "legs" => 95,  "feet" => 95  ],
            "Fury"          => [ "addons" => 3, "head" => 94,  "body" => 77,  "legs" => 96,  "feet" => 0   ],
            "Hunter"        => [ "addons" => 0, "head" => 95,  "body" => 116, "legs" => 120, "feet" => 115 ],
            "Smuggler"      => [ "addons" => 0, "head" => 95,  "body" => 0,   "legs" => 113, "feet" => 115 ],
            "Stalker"       => [ "addons" => 0, "head" => 97,  "body" => 116, "legs" => 95,  "feet" => 95  ],
            "Valkyrie"      => [ "addons" => 0, "head" => 113, "body" => 38,  "legs" => 76,  "feet" => 96  ],
            "Warlock"       => [ "addons" => 0, "head" => 0,   "body" => 52,  "legs" => 128, "feet" => 95  ],
        ];

        $monsterDeleted = [

            "Flamethrower", "Magicthrower", "Plaguethrower", "Shredderthrower", "Grinch", "Evil Grinch", "Gamemaster", "Dummy Target", "Fury", "Dummy Target Ravenor", "Bring Me The Halloween", "Dummy Elite", "Dummy Target Ravenor", 
        ];

        $creatures = array_filter($creatures, function ($creature) use ($monsterDeleted) {
            return !in_array($creature['name'], $monsterDeleted);
        });

        $creatures = array_values($creatures);

    @endphp

    <style>

        .item_search_input {
            transition: box-shadow 0.3s ease; 
        }
    
        .item_search_input:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); 
        }

        .creatureListBox {
            height: 90px;
            width: 50px;
            text-align: center;
            font: bold 12px Arial;
            display: flex;
            flex-direction: column;
            justify-content: center; 
            align-items: center; 
            position: relative;
            margin: 0 auto;
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

    </style>

    <div class="TableContainer">
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
                        <td>
                            <br>

                            <div style="display: flex; gap: 4px; justify-content: left;">
                                <div id="btnMonsters" style="border: 2px solid rgba(121, 61, 3, 0.65); border-radius: 4px; background-color: rgba(255, 255, 255, 0.46); box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); width: 120px; text-align: center; padding: 10px; cursor: pointer;">
                                    <label style="color: rgb(90, 40, 0)">Monsters</label>
                                </div>
                            
                                <div id="btnBosses" style="border: 2px solid rgba(121, 61, 3, 0.65); border-radius: 4px; background-color: rgba(255, 255, 255, 0.46); box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); width: 120px; text-align: center; padding: 10px; cursor: pointer;">
                                    <label style="color: #004294">Bosses</label>
                                </div>
                            </div>
                    
                            <br>
                    
                            <div style="display: inline-block; position: relative;">
                                <span style="position: absolute; left: 7px; top: 50%; transform: translateY(-50%);">
                                    <img src="{{ asset('images/ser1.png') }}" alt="Ícone de Pesquisa" style="width: 20px; height: 20px;">
                                </span>
                                <input id="search_creature" type="text" class="item_search_input" name="search_creature" placeholder="Search Monster.." style="padding-left: 30px; height: 30px; width: 200px; border-radius: 4px; border: 1px solid #ccc;">
                            </div>
                            
                            <br><br>
                        </td>
                    </tr>
                        

                    <tr>
                        <td colspan="4">
                            <small>
                                <div style="float: left; padding-bottom: 7px" id="paginationLeft"></div>
                                <div style="float: right; padding-right: 10px; padding-bottom: 7px" id="paginationRight"></div>
                            </small>
                            <div style="clear: both;"></div>                            
                        </td>
                    </tr>

                    <tr>
                        <td><div class="TableContentContainer">

                           
                            <table id="tableContainer" class="TableContent">
                                <thead>
                                    <tr bgcolor="#505050">
                                        <td width="45%" class="LabelH">Name <small><a href="#" class="sort" data-column="name">[Sort]</a></small></td>
                                        <td class="LabelH">Image</td>
                                        <td class="LabelH">HP <small><a href="#" class="sort" data-column="health">[Sort]</a></small></td>
                                        <td class="LabelH">Experience <small><a href="#" class="sort" data-column="experience">[Sort]</a></small></td>
                                    </tr>
                                </thead>
                                <tbody id="creatureTableBody">
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

    <table style="margin: 0 auto">

    </table>

    <div id="creatureData" data-creatures='<?php echo htmlspecialchars(json_encode($creatures), ENT_QUOTES, 'UTF-8'); ?>'></div>
    <div id="creatureOutfit" data-creaturesoutfit='<?php echo htmlspecialchars(json_encode($creaturesOutfit), ENT_QUOTES, 'UTF-8'); ?>'></div>

    <script src="{{ asset('assets/tibiarl/js/about/wiki/creatures.min.js') }}?v=2" defer></script>

@endsection

