@extends('template.layout')
@section('title', 'Items')
@section('submenuItem', 'items')
@section('content')

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
            border: 2px solid rgba(121, 61, 3, 0.65);
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.46);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            position: relative
        }

        tr{
            position: relative;
            text-align:center;
            border: 2px solid rgba(121, 61, 3, 0.65);
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.46);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        td{
            position: relative
        }
        
        table{

            border-spacing: 0px !important;
        }

    </style>

    @php

        function generateHeader($headerFrames, $centralText) {

            $headerHtml = '<div class="CaptionContainer"><div class="CaptionInnerContainer">';
            
            foreach ($headerFrames as $class => $style) {
                if ($class === 'Text') {
                    $headerHtml .= '<div class="'.$class.'" style="'.$style.'">'.$centralText.'</div>';
                } else {
                    $headerHtml .= '<span class="'.$class.'" style="background-image:url(/assets/tibiarl/images/content/'.$headerFrames[$class].');"></span>';
                }
            }

            $headerHtml .= '</div></div>';

            return $headerHtml;
        }
        
        $headerFrames = [
            'CaptionEdgeLeftTop' => 'box-frame-edge.gif',
            'CaptionEdgeRightTop' => 'box-frame-edge.gif',
            'CaptionBorderTop' => 'table-headline-border.gif',
            'CaptionVerticalLeft' => 'box-frame-vertical.gif',
            'Text' => '',
            'CaptionVerticalRight' => 'box-frame-vertical.gif',
            'CaptionBorderBottom' => 'table-headline-border.gif',
            'CaptionEdgeLeftBottom' => 'box-frame-edge.gif',
            'CaptionEdgeRightBottom' => 'box-frame-edge.gif'
        ];

        function generateTable($headerFrames, $centralText, $tableTitle, $numRows, $itemsPerRow, $itemsArray) {

            $headerHtml = generateHeader($headerFrames, $centralText);

            $tableHtml = '<div class="TableContainer">' . $headerHtml . '<table class="Table3" cellpadding="0" cellspacing="0"><tbody><tr><td>';
            $tableHtml .= '<div style="width: unset;"><div ></div></div><div style="max-width: unset;"><table style="width:100%;"><tbody>';

            for ($i = 0; $i < $numRows; $i++) {
                $tableHtml .= '<tr>';

                for ($j = 0; $j < $itemsPerRow; $j++) {
                    $tableHtml .= '<td>';

                    if (isset($itemsArray[$i * $itemsPerRow + $j])) {
                        $item = $itemsArray[$i * $itemsPerRow + $j];
                        $tableHtml .= sprintf('<a href="%s"><div class="creatureListBox">', route('about.itemsView', ['name' => $item['name']]));
                        $tableHtml .= '<img src="/items/'.$item['id'].'.gif">';
                        $tableHtml .= '</div>';
                        $tableHtml .= '<label style="position: absolute; left: 50%; top: 80%; transform: translate(-50%, -50%); width: 150px">'.$item['name'].'</label></a>';
                    }

                    $tableHtml .= '</td>';
                }

                $tableHtml .= '</tr>';
            }

            $tableHtml .= '</tbody></table></div></td></tr></tbody></table></div>';

            return $tableHtml;
        }


        $tableTitle = 'Item';
        $numRows = 2;
        $itemsPerRow = 5;

        $itemsArray = [
            ['id' => 3387, 'name' => 'Helmets'],
            ['id' => 3388, 'name' => 'Armors'],
            ['id' => 3389, 'name' => 'Legs'],
            ['id' => 3079, 'name' => 'Boots'],
            ['id' => 3420, 'name' => 'Shields']
        ];

        echo generateTable($headerFrames, "Equipaments", $tableTitle, $numRows, $itemsPerRow, $itemsArray) . "<br>";

        $itemsArray = [
            ['id' => 3319, 'name' => 'Axes'],
            ['id' => 3309, 'name' => 'Clubs'],
            ['id' => 3288, 'name' => 'Swords'],
            ['id' => 3349, 'name' => 'Distances Weapons'],
            ['id' => 1781, 'name' => 'Throwing Weapons'],
            ['id' => 3447, 'name' => 'Ammunitions'],
            ['id' => 5744, 'name' => 'Wands'],
            ['id' => 5759, 'name' => 'Quivers'],
        ];

        echo generateTable($headerFrames, "Weapons", $tableTitle, $numRows, $itemsPerRow, $itemsArray) . "<br>";

        $numRows = 4;
        $itemsPerRow = 5;
        
        $itemsArray = [
            ['id' => 3057, 'name' => 'Amulets'],
            ['id' => 3006, 'name' => 'Rings'],
            ['id' => 3152, 'name' => 'Runes'],
            ['id' => 3457, 'name' => 'Tools'],
            // ['id' => 2921, 'name' => 'Light sources'],

            ['id' => 5097, 'name' => 'Valuables'],
            ['id' => 5103, 'name' => 'Containers'],
            // ['id' => 2901, 'name' => 'Fluids'],
            // ['id' => 2876, 'name' => 'Fluid Containers'],
            ['id' => 3577, 'name' => 'Foods'],

            // ['id' => 5210, 'name' => 'Decorations'],
            // ['id' => 2029, 'name' => 'Furnitures'],
            // ['id' => 2816, 'name' => 'Books'],
            // ['id' => 3471, 'name' => 'Kitchen Tools'],
            // ['id' => 2950, 'name' => 'Instruments'],

            // ['id' => 3240, 'name' => 'Others'],
            // ['id' => 5112, 'name' => 'Creature Products'],
        ];

        echo generateTable($headerFrames, "Others", $tableTitle, $numRows, $itemsPerRow, $itemsArray) . "<br>";

    @endphp

@endsection

