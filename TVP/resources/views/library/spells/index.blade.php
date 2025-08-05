@extends('template.layout')
@section('title', 'Spells')
@section('submenuItem', 'spells')
@section('content')

    @php
        include "./spells.php";
        
        usort($spells, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
    @endphp

    <style>
        select {
            width: 120px;
            height: 30px;
            background-color: white;
            color: #333;
            border-radius: 5px; 
            font-size: 14px; 
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            appearance: auto;
            outline: none;
            cursor: pointer;
        }

        select:focus {
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.2); 
        }

        select::-ms-expand {
            display: block;
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

    Here you can see the list of all available spells in {{ config('server.serverName') }}. Please adjust the search criteria below if you want to see just certain spells. Also, you can sort the spell list by any column of your choice.<br><br><br>

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Spell Search</div>
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
                                                <td width="25%"><b>Vocation:</b></td>
                                                <td width="25%"><b>Type:</b></td>
                                                <td width="25%"><b>Premium:</b></td>
                                            </tr>
                                            <tr bgcolor="#D4C0A1">
                                                <td>
                                                    <div>
                                                        <div style="display: inline-block; position: relative;">
                                                            <span style="position: absolute; left: 7px; top: 50%; transform: translateY(-50%);">
                                                                <img src="/images/ser1.png" alt="Ícone de Pesquisa" style="width: 20px; height: 20px;">
                                                            </span>
                                                            <input id="search_spell" type="text" class="item_search_input" name="search_spell" value="" placeholder="Search Spell.." style="padding-left: 30px;"  autocomplete="off">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td valign="top">
                                                    <select name="vocacao" id="vocacao"  autocomplete="off">
                                                        <option value="all">All</option>
                                                        @foreach (['Sorcerer', 'Master Sorcerer', 'Druid', 'Elder Druid', 'Paladin', 'Royal Paladin', 'Knight', 'Elite Knight'] as $vocation)
                                                            <option value="{{ strtolower(str_replace(' ', ' ', $vocation)) }}">{{ $vocation }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>                                                
                                                
                                                <td valign="top">
                                                    <select name="tipo" id="tipo" autocomplete="off">
                                                        <option value="all">All</option>
                                                        <option value="instant">Instant</option>
                                                        <option value="rune">Rune</option>
                                                        <option value="conjuring">Conjure</option>
                                                    </select>
                                                </td>
                                                
                                                <td valign="top">
                                                    <select name="premium" id="premium" autocomplete="off">
                                                        <option value="all">All</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
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

    <br>

    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Spells  <span id="totalSpells" style="float: right; margin-right: 5px">Total found: {{ count($spells) }}</span></div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table3" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="TableScrollbarWrapper" style="width: unset;">
                        <div class="TableScrollbarContainer"> </div>
                    </div>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr bgcolor="#505050">
                                                <td width="45%" class="LabelH">Name <small><a href='#' class='sort' data-column='name'>[Sort]</a></small></td>
                                                <td class="LabelH">Type</td>
                                                <td class="LabelH">Magic Level <small><a href='#' class='sort' data-column='mgcLvl'>[Sort]</a></small></td>
                                                <td class="LabelH">Mana <small><a href='#' class='sort' data-column='mana'>[Sort]</a></small></td>
                                                <td class="LabelH">Premium <small><a href='#' class='sort' data-column='premium'>[Sort]</a></small></td>
                                            </tr>
                                            @forelse($spells as $spell)
                                                @php
                                                    $rowClass = $loop->index % 2 == 0 ? 'Even' : 'Odd';
                                                @endphp
                                                <tr class="rowPage {{ $rowClass }}">

                                                    <td data-column="name" data-vocation="{{ implode(',', $spell['vocation']) }}">
                                                        <a href="/about/spellView/{{ urlencode($spell['name']) }}">
                                                            {{ $spell['name'] }}
                                                            @if($spell['category'] == 'rune' && !str_contains(strtolower($spell['name']), 'rune'))
                                                                Rune
                                                            @endif
                                                        </a>
                                                        ({{ $spell['words'] }})
                                                    </td>

                                                    <td>
                                                        {{ $spell['category'] }}
                                                    </td>

                                                    <td data-column='mgcLvl'>
                                                        {{ $spell['magicLevel'] }}
                                                    </td>

                                                    <td data-column='mana'>
                                                        @if(isset($spell['mana']))
                                                            {{ $spell['mana'] }}
                                                        @else
                                                            0
                                                        @endif
                                                    </td>
                                                    
                                                    <td data-column='premium'>
                                                        @if(isset($spell['isPremium']))
                                                            Yes
                                                        @else
                                                            No
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                            @endforelse
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

    <br><br>

    <script>
        document.addEventListener("DOMContentLoaded",(function(){const e=document.getElementById("tipo"),t=document.getElementById("premium"),o=document.getElementById("vocacao"),n=document.getElementById("totalSpells"),a=document.getElementById("search_spell");function l(){const e=document.querySelectorAll(".Table3 .rowPage");e.forEach((e=>{e.classList.remove("Odd","Even")}));let t="";e.forEach((e=>{"none"!==e.style.display&&("Even"===t?(e.classList.add("Odd"),t="Odd"):(e.classList.add("Even"),t="Even"))}))}function r(){const o=document.querySelectorAll(".Table3 .rowPage"),r=e.value.toLowerCase(),d=t.value.toLowerCase(),s=document.getElementById("vocacao").value.toLowerCase(),i=a.value.trim().toLowerCase();o.forEach((e=>{const t=e.querySelector("td:nth-child(2)"),o=t?t.textContent.trim().toLowerCase():"",n=e.querySelector("td:nth-child(5)"),a=n?n.textContent.trim().toLowerCase():"",l=e.querySelector("td[data-vocation]"),c=l?l.getAttribute("data-vocation").toLowerCase():"",u=e.querySelector("td:nth-child(1)"),m=u?u.textContent.trim().toLowerCase():"",y="all"===s||c.includes(s),C="all"===r||r===o,v="all"===d||d===a,L=""===i||m.includes(i);e.style.display=C&&v&&y&&L?"":"none"})),l(),function(){const e=document.querySelectorAll('.Table3 .rowPage:not([style*="display: none"])');n.textContent=`Total found: ${e.length}`}(),null!==lastSortedColumn&&null!==lastSortDirection&&c(lastSortedColumn,lastSortDirection)}function c(e,t){lastSortedColumn=e,lastSortDirection=t;const o=document.querySelectorAll(".Table3 .rowPage");var n=Array.from(o).filter((e=>"none"!==e.style.display));n.sort((function(o,n){var a=o.querySelector('td[data-column="'+e+'"]').textContent.trim(),l=n.querySelector('td[data-column="'+e+'"]').textContent.trim();return"name"===e?(a=a.toLowerCase(),l=l.toLowerCase(),t?a<l?1:-1:a>l?1:-1):"premium"===e?(a="yes"===a.toLowerCase()?1:0,l="yes"===l.toLowerCase()?1:0,t?l-a:a-l):($.isNumeric(a)&&$.isNumeric(l)&&(a=parseFloat(a),l=parseFloat(l)),t?a<l?1:-1:a>l?1:-1)})),n.forEach((e=>{$("table.TableContent").eq(1).find("tbody").append(e)})),l()}e.addEventListener("change",r),t.addEventListener("change",r),o.addEventListener("change",r),a.addEventListener("input",r),r(),$(".sort").click((function(e){e.preventDefault();var t=$(this).data("column"),o="[Sort]"===$(this).text().trim();o?$(this).text("[Unsort]"):$(this).text("[Sort]"),c(t,o)}))}));
    </script>

    <center>
        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                <input class="BigButtonText" type="submit" value="Submit">
            </div>
        </div>
    </center>

    </form>

@endsection

