@section('title', $playerInfo->name)
@section('submenuItem', 'characters')
@php
    $number_of_rows = 0;
    date_default_timezone_set('America/Sao_Paulo');
@endphp

@if($banInfo != null)
    {!! $formaters->small_box('
        <div style="display:flex; align-items:center; justify-content:center; margin: auto; gap: 10px">
            <img src="/assets/tibiarl/images/content/attentionsign.gif" alt="Attention Sign">
            <span style="color:red">This account is banned</span>
        </div>
    ') !!}
    <br>
@endif

<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">Character Information</div>
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

                                        @if ($formerName)
                                            <tr class="{{ (($number_of_rows++ % 2 == 1) ?  'Even' : 'Odd') }}">
                                                <td width="20%" class="LabelV175">Former Name:</td>
                                                <td>{{ $formerName->name }}<div style="float: right"></div>
                                                </td>
                                            </tr>
                                        @endif

                                        <tr class="{{ (($number_of_rows++ % 2 == 1) ?  'Even' : 'Odd') }}">
                                            <td width="20%" class="LabelV175">Name:</td>
                                            <td>{{ $playerInfo->name }} <div style="float: right"></div>
                                            </td>
                                        </tr>
                                        <tr class="{{ (($number_of_rows++ % 2 == 1) ?  'Even' : 'Odd') }}">
                                            <td class="LabelV175">Sex:</td>
                                            <td>{{ $playerInfo->sex === 0 ? 'Female' : 'Male' }}</td>
                                        </tr>
                                        <tr class="{{ (($number_of_rows++ % 2 == 1) ?  'Even' : 'Odd') }}">
                                            <td class="LabelV175">Vocation:</td>
                                            <td>{{ \App\Utils\Vocation::getNameByVocationId($playerInfo->vocation) }}</td>
                                        </tr>
                                        <tr class="{{ (($number_of_rows++ % 2 == 1) ?  'Even' : 'Odd') }}">
                                            <td class="LabelV175">Level:</td>
                                            <td>{{ $playerInfo->level }}</td>
                                        </tr>
                                        <tr class="{{ (($number_of_rows++ % 2 == 1) ?  'Even' : 'Odd') }}">
                                            <td class="LabelV175">World:</td>
                                            <td>{{ config('server.worlds')[0] }}</td>
                                        </tr>
                                        <tr class="{{ (($number_of_rows++ % 2 == 1) ?  'Even' : 'Odd') }}">
                                            <td class="LabelV175">Residence:</td>
                                            <td>{{ \App\Utils\Town::getTownById($playerInfo->town_id)['name'] }}</td>
                                        </tr>
                                        @if(!empty($playerInfo->house))
                                            <tr class="{{ (($number_of_rows++ % 2 == 1) ?  'Even' : 'Odd') }}">
                                            <td class="LabelV175">House:</td>
                                            <td><a href="{{ route('community.view.house.index', [$playerInfo->house->id]) }}">{{ $playerInfo->house->name  }}</a> ({{ \App\Utils\Town::getTownById($playerInfo->house->town_id)['name'] }}) is paid until {{ date('M d, Y', $playerInfo->house->paid) }}</td>
                                        </tr>
                                        @endif
                                        @if(!empty($playerInfo->guild_membership))
                                        <tr class="{{ (($number_of_rows++ % 2 == 1) ?  'Even' : 'Odd') }}">
                                            <td class="LabelV175">Guild Membership:</td>
                                            <td>
                                                {{ $playerInfo->guild_membership->ranks->name }} of the
                                                <a href="{{ route('community.view.guild.index', Str::strToUrl($playerInfo->guild_membership->guild->name)) }}">{{ $playerInfo->guild_membership->guild->name }}</a>
                                                @if(!empty($playerInfo->guild_membership->nick))
                                                    ({{$playerInfo->guild_membership->nick}})
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                        <tr class="{{ (($number_of_rows++ % 2 == 1) ?  'Even' : 'Odd') }}">
                                            <td class="LabelV175">Last Login:</td>
                                            <td>
                                                @if($playerInfo->lastlogin === 0)
                                                    Never logged in
                                                @else
                                                    {{ date('M d Y, H:i:s', $playerInfo->lastlogin) }} BRT
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="{{ (($number_of_rows++ % 2 == 1) ?  'Even' : 'Odd') }}">
                                            <td class="LabelV175">Account&nbsp;Status:</td>
                                            <td>
                                                @if($playerInfo->account->isPremium())
                                                    Premium Account
                                                @else
                                                    Free Account
                                                @endif
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
@if(true)
<br>
<br>
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">Character Deaths</div>
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
                                        @foreach($playerInfo->deaths as $death)
                                            @php
                                                $rowClass = $loop->index % 2 == 0 ? 'Odd' : 'Even';
                                            @endphp
                                            <tr class="{{ $rowClass }}">
                                                <td style="width: 25%"><nobr>{{ date('M d Y, H:i:s', $death->time) }}</nobr> BRT</td>
                                                <td>Killed at Level {{ $death->level }} by @if(!$death->is_player) {{ Str::strWithArticle($death->killed_by) }} @else <a href="{{ route('community.view.character.search',  Str::strToUrl($death->killed_by)) }}">{{ $death->killed_by }}</a>@if($death->unjustified) <span class="ColorRed">(Unjustified)</span> @endif @endif @if($death->killed_by !== $death->mostdamage_by) and by @if(!$death->mostdamage_is_player) {{ Str::strWithArticle($death->mostdamage_by) }} @else <a href="{{ route('community.view.character.search', Str::strToUrl($death->mostdamage_by)) }}">{{ $death->mostdamage_by }}</a>@if($death->unjustified) <span class="ColorRed">(Unjustified)</span> @endif @endif @endif</td>
                                            </tr>
                                        @endforeach
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
@if(!$playerInfo->hidden)
<br>
<br>
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">Account Information</div>
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
                                        <tr class="Odd">
                                            <td class="LabelV175" style="width: 20%">Created:</td>
                                            <td>
                                                @if (!is_null($playerInfo->webaccount) && !is_null($playerInfo->webaccount->created_at))
                                                    {{ date('M d Y, H:i:s', strtotime($playerInfo->webaccount->created_at)) }} BRT
                                                @else
                                                    Not found
                                                @endif
                                            </td>                                                                                      
                                        </tr>
                                        <tr class="Even">
                                            <td class="LabelV175" style="width: 20%">Position:</td>
                                            <td>
                                                @if(isset(config('positions')[$playerInfo->account->type]))
                                                    {{ config('positions')[$playerInfo->account->type]['name'] }}
                                                @else
                                                    Unknown
                                                @endif
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
@endif
<br>
<br>
@if(!$playerInfo->hidden)
<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
            <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
            <div class="Text">Characters</div>
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
                                            <td>Name</td>
                                            <td>World</td>
                                            <td>Status</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        @foreach($playerInfo->list->where('hidden', '=', false) as $character)
                                            @php
                                                $rowClass = $loop->index % 2 == 0 ? 'Even' : 'Odd';
                                            @endphp
                                            <tr class="{{ $rowClass }}">
                                                <td style="width: 20%">
                                                    <nobr>{{ $loop->iteration }}. {{ $character->name }}@if($character->name === $playerInfo->name)@endif</nobr>
                                                </td>
                                                <td style="width: 10%">
                                                    <nobr>{{ config('server.worlds')[0] }}</nobr>
                                                </td>
                                                <td style="width: 70%">@if(!is_null($character->online)) <b class="green">online</b> @endif</td>
                                                <td>
                                                    <div onclick="RedirectToUrl('{{ route('community.view.character.search', Str::strToUrl($character->name)) }}');">
                                                        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this)" onmouseout="MouseOutBigButton(this)"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }})"></div>
                                                                <input class="BigButtonText" type="submit" value="View">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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
<br>