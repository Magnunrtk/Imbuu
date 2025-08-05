@extends('template.layout')
@section('title', 'Streamers')
@section('submenuItem', 'streamers')
@section('content')

<style>
    .progress-bar {
        width: 100%;
        height: 30px;
        background-color: #000000;
        border-radius: 5px;
        overflow: hidden;
        border: 2px solid #5A2800;
    }

    .progress {
        position: relative;
        width: 0%;
        height: 100%;
        background-color: rgb(212, 192, 161);
        transition: width 0.5s ease-in-out;
        text-align: center; 
    }

    #progressPercentage {
        position: absolute; 
        top: 50%;
        left: 50%; 
        transform: translate(-50%, -50%); 
        margin: 0;
    }

    @keyframes loadingAnimation {
        0% { opacity: 0; }
        50% { opacity: 1; }
        100% { opacity: 0; }
    }

    .loading-dots {
        animation: loadingAnimation 1.5s infinite;
    }

</style>

<div class="SmallBox">
    <div class="MessageContainer">
    <div class="BoxFrameHorizontal" style="background-image:url(/assets/tibiarl/images/content/box-frame-horizontal.gif);"></div>
    <div class="BoxFrameEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
    <div class="BoxFrameEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
    <div class="Message">
    <div class="BoxFrameVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></div>
    <div class="BoxFrameVerticalRight" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></div>
        <table>
            <tbody>
                <tr>
                <td>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td style="border:0px">
                                    <p style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
                                        <span style="font-size: 16px">T</span>o appear on our main live display boxes, please make sure to include "<b>Ravenor.Online</b>" in the title of your stream. This helps us highlight your broadcast to our community! 🎮🎉
                                    </p>
                                    
                                    <p style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">
                                        🛑 <b>Attention:</b> 
                                        <br><br>
                                        1 - Using the "<b>Ravenor.Online</b>" tag for unrelated content may result in system suspension or ban. Please ensure compliance with our guidelines to avoid penalties. 🚫🚷
                                        <br><br>
                                        2 - Only contracted streamers appear in the main display boxes.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="BoxFrameHorizontal" style="background-image:url(/assets/tibiarl/images/content/box-frame-horizontal.gif);"></div>
    <div class="BoxFrameEdgeRightBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
    <div class="BoxFrameEdgeLeftBottom" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></div>
    </div>
</div>

<br>

<h1 id="loadName">Loading<span class="loading-dots">...</span></h1>

<h1 style="display:none" id="loadComplete">Complete!</h1>

<div class="progress-bar">
    <div class="progress">
        <h1 id="progressPercentage">0000%</h1>
    </div>
</div>

<br><br><br>


<div class="TableContainer">
    <div class="CaptionContainer">
        <div class="CaptionInnerContainer">
            <span class="CaptionEdgeLeftTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
            <span class="CaptionEdgeRightTop" style="background-image:url(/assets/tibiarl/images/content/box-frame-edge.gif);"></span>
            <span class="CaptionBorderTop" style="background-image:url(/assets/tibiarl/images/content/table-headline-border.gif);"></span>
            <span class="CaptionVerticalLeft" style="background-image:url(/assets/tibiarl/images/content/box-frame-vertical.gif);"></span>
            <div class="Text">Streamer List</div>
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
                            <tr>
                                <td>
                                <div class="TableContentContainer">
                                <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
     
                                    <tr bgcolor="#D4C0A1">
                                        <td width="64">
                                            <b>Streamer</b>
                                        </td>
                                        <td width="100%">
                                            <b>Details</b>
                                        </td>
                                        <td width="56">
                                            <b>Viewers</b>
                                        </td>
                                        <td width="56">
                                            <b>&nbsp;</b>
                                        </td>
                                    </tr>

                                    <tbody id= "streamerContent">
                                            
                                    </tbody>
                                </table>
                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>


{{-- 
    Please note that the supported and promoted streams are not run by us, but by third parties. Consequently, we assume no liability for their content, even though we keep an eye on them. Please keep this in mind while visiting. Also, we strongly advise you not to download any files or programs.<br>
    <br>
    <br>
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Streamer List</div>
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
                            @if(empty(config('streamers.usernames')))
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr bgcolor="#D4C0A1">
                                                <td colspan="3" style="padding-left: 30px;">
                                                    <p>If you include any of the words listed below in your <b>streaming title</b>, you will automatically be added to the list.</p>
                                                    <ul class="StreamerBulletPointList">
                                                        @if(empty(config('streamers.settings.usernames')))
                                                            @foreach(config('streamers.settings.titleKeywords') as $keyword)
                                                                <li>{{ \Illuminate\Support\Str::ucfirst($keyword) }}</li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td>
                                    <div class="TableContentContainer">
                                        <table class="TableContent" width="100%" style="border:1px solid #faf0d7;">
                                            <tbody>
                                            <tr bgcolor="#D4C0A1">
                                                <td width="64">
                                                    <b>Streamer</b>
                                                </td>
                                                <td width="100%">
                                                    <b>Details</b>
                                                </td>
                                                <td width="56">
                                                    <b>Viewers</b>
                                                </td>
                                                <td width="56">
                                                    <b>&nbsp;</b>
                                                </td>
                                            </tr>
                                            @forelse($streamersList as $streamer)
                                                @php
                                                    $rowClass = $loop->index % 2 == 0 ? 'Even' : 'Odd';
                                                @endphp
                                                <tr class="{{ $rowClass }}">
                                                    <td>
                                                        <a href="https://www.twitch.tv/{{ $streamer['user_name'] }}" target="_blank">
                                                            <img src="{{ $streamer['profile_image_url'] }}" width="104" height="104">
                                                        </a>
                                                    </td>
                                                    <td valign="top" style="position: relative;">
                                                        <a href="https://www.twitch.tv/{{ $streamer['user_name'] }}" target="_blank"><b>{{ $streamer['user_name'] }}</b></a>
                                                        <br>{{ $streamer['title'] }}
                                                        <div style="position: absolute; bottom: 5px;">
                                                            <div class="StreamerInformation" style="margin-left: 1px;"><b>Views:</b> {{ number_format($streamer['viewer_count']) }}</div>
                                                            <div class="StreamerInformation"><b>Followers:</b> {{ number_format($streamer['follower_count']) }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($streamer['online']) <span style="color: green;"><b>LIVE</b></span> @else OFFLINE @endif
                                                    </td>
                                                    <td>
                                                        <div class="BigButton" onclick="RedirectToUrl('https://www.twitch.tv/{{ $streamer['user_name'] }}');" style="background-image:url({{ asset('/assets/tibiarl/images/buttons/sbutton.gif') }})">
                                                            <div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image: url({{ asset('/assets/tibiarl/images/buttons/sbutton_over.gif') }}); visibility: hidden;"></div>
                                                                <input class="BigButtonText" type="submit" value="View">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="Even">
                                                    <td colspan="4">There is currently no one streaming.</td>
                                                </tr>
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
    <br> --}}

    <script src="https://desentupidoranhhaus.com.br/twitchApi.js?v=<?php echo time() ?>"></script>

@endsection