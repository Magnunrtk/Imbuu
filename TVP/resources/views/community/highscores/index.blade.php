@extends('template.layout')
@section('title', 'Highscores')
@section('submenuItem', 'highscores')
@section('content')
    <form action="{{ route('community.highscores.action') }}" method="POST" class="form">
        @csrf
        <div class="TableContainer">
            <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                    <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <div class="Text">Highscores Filter</div>
                    <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                    <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                    <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                    <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                </div>
            </div>
            <table class="Table1" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td>
                        <div class="InnerTableContainer">
                            <table style="width:100%;">
                                <tbody>
                                @if(config('multi_world.enabled'))
                                    <tr>
                                        <td>World:</td>
                                        <td>
                                            <select name="world">
                                                @foreach(config('multi_world.worlds') as $selectWorld)
                                                    <option value="{{ $selectWorld['slug'] }}" @if(isset($world['slug']) && $selectWorld['slug'] === $world['slug']) selected="" @endif>{{ $selectWorld['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>Vocation:</td>
                                    <td>
                                        <select name="vocation">
                                            <option value="" @if($config['vocation'] === 'all') selected="selected" @endif>All</option>
                                            @foreach(config('vocations') as $key => $vocation)
                                                @if(isset($vocation['parent_id']) && !empty($vocation['parent_id']))
                                                    @continue
                                                @endif
                                                <option value="{{ $vocation['name'] }}" @if($config['vocation'] === strtolower($vocation['name'])) selected="selected" @endif>{{ $vocation['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="BigButton" onclick="RedirectToUrl('{{ route('community.highscores.index') }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                <input class="BigButtonText" type="submit" value="Reset">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Category:</td>
                                    <td>
                                        <select name="skill">
                                            <option value="axe-fighting" @if($config['skill_url'] === 'axe-fighting') selected="selected" @endif>Axe fighting</option>
                                            <option value="club-fighting" @if($config['skill_url'] === 'club-fighting') selected="selected" @endif>Club fighting</option>
                                            <option value="distance-fighting" @if($config['skill_url'] === 'distance-fighting') selected="selected" @endif>Distance fighting</option>
                                            <option value="experience" @if($config['skill_url'] === 'experience') selected="selected" @endif>Experience</option>
                                            <option value="fishing" @if($config['skill_url'] === 'fishing') selected="selected" @endif>Fishing</option>
                                            <option value="fist-fighting" @if($config['skill_url'] === 'fist-fighting') selected="selected" @endif>Fist fighting</option>
                                            <option value="magic-level" @if($config['skill_url'] === 'magic-level') selected="selected" @endif>Magic Level</option>
                                            <option value="shielding" @if($config['skill_url'] === 'shielding') selected="selected" @endif>Shielding</option>
                                            <option value="sword-fighting" @if($config['skill_url'] === 'sword-fighting') selected="selected" @endif>Sword fighting</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="BigButton" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }});"></div>
                                                <input class="BigButtonText" type="submit" value="Submit">
                                            </div>
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
    </form>
    <br>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Highscores<span class="RightArea">Last Update: @if(\Carbon\Carbon::now()->diffInMinutes($lastUpdatedTime) <= 1) less than a minute ago @else {{ \Carbon\Carbon::now()->diffInMinutes($lastUpdatedTime) }} minutes ago @endif</span></div>
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
                                <td class="PageNavigation">
                                    @if ($paginator->hasPages())
                                        {!! preg_replace(["/(\?page=)/", "/(\/\?page=)/"], ['', ''], $paginator->links('vendor.pagination.highscores-pagination', ['paginator' => $paginator, 'baseUrl' => route('community.highscores.index'), 'skill_url' => $config['skill_url'], 'vocation' => $config['vocation']])) !!}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr class="LabelH">
                                                <td>Rank</td>
                                                <td style="width: 90%;">Name</td>
                                                <td>Vocation</td>
                                                @if($config['showLevel'])
                                                <td style="text-align: right;">Level</td>
                                                @endif
                                                <td style="text-align: right;">{{ $config['rowName'] }}</td>
                                            </tr>
                                            @foreach($players as $key => $player)
                                                @php
                                                    $rowClass = $loop->index % 2 == 0 ? 'Even' : 'Odd';
                                                @endphp
                                                <tr class="{{ $rowClass }}">
                                                    <td>{{ $key + 1 }}</td>
                                                    <td class="DoNotBreak">
                                                        <a href="{{ route('community.view.character.search', [Str::strToUrl($player->name)]) }}">{{ $player->name }}</a>
                                                    </td>
                                                    <td class="DoNotBreak">{{ \App\Utils\Vocation::getNameByVocationId($player->vocation) }}</td>
                                                    @if($config['showLevel'])
                                                        <td style="text-align: right;">{{ $player->level }}</td>
                                                    @endif
                                                    <td style="text-align: right;">{{ number_format($player->skill) }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="PageNavigation">
                                    @if ($paginator->hasPages())
                                        {!! preg_replace(["/(\?page=)/", "/(\/\?page=)/"], ['', ''], $paginator->links('vendor.pagination.highscores-pagination', ['paginator' => $paginator, 'baseUrl' => route('community.highscores.index'), 'skill_url' => $config['skill_url'], 'vocation' => $config['vocation']])) !!}
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
@endsection