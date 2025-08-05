<div id="newsticker" class="Box">
    <div class="Corner-tl" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-tl.gif') }});"></div>
    <div class="Corner-tr" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-tr.gif') }});"></div>
    <div class="Border_1" style="background-image:url({{ asset('/assets/tibiarl/images/content/border-1.gif') }});"></div>
    <div class="BorderTitleText" style="background-image:url({{ asset('/assets/tibiarl/images/content/title-background-green.gif') }});"></div>
    <img class="Title" src="{{ asset('/assets/tibiarl/images/header/headline-newsticker.gif') }}" alt="Contentbox headline">
    <div class="Border_2">
        <div class="Border_3">
            <div class="BoxContent" style="background-image:url({{ asset('/assets/tibiarl/images/content/scroll.gif') }});">
                @foreach($newsTicker as $ticker)
                    @php
                        $rowClass = $loop->index % 2 == 0 ? 'Odd' : 'Even';
                    @endphp
                    <div id="TickerEntry-{{ $loop->index }}" class="Row" onclick="TickerAction('TickerEntry-{{ $loop->index }}')">
                        <div class="{{ $rowClass }}">
                            <div class="NewsTickerIcon" style="background-image:url({{ asset('/assets/tibiarl/images/news/icon_'. $ticker->icon_id .'.gif') }})"></div>
                            <div id="TickerEntry-{{ $loop->index }}-Button" class="NewsTickerExtend" style="background-image: url({{ asset('/assets/tibiarl/images/general/plus.gif') }});"></div>
                            <div class="NewsTickerText">
                                <span class="NewsTickerDate">{{ date('M d Y', strtotime($ticker->created_at)) }}&nbsp;-&nbsp;</span>
                                <span id="TickerEntry-{{ $loop->index }}-Time" class="NewsTickerTime">{{ date('H:i', strtotime($ticker->created_at)) }}</span>
                                <div class="NewsTickerTextContainer">
                                    <div id="TickerEntry-{{ $loop->index }}-ShortText" class="NewsTickerShortText">
                                        <p>{!! $ticker->body !!}</p>
                                    </div>
                                    <div id="TickerEntry-{{ $loop->index }}-FullText" class="NewsTickerFullText">
                                        <p>{!! $ticker->body !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="Border_1" style="background-image:url({{ asset('/assets/tibiarl/images/content/border-1.gif') }});"></div>
    <div class="CornerWrapper-b"><div class="Corner-bl" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-bl.gif') }});"></div></div>
    <div class="CornerWrapper-b"><div class="Corner-br" style="background-image:url({{ asset('/assets/tibiarl/images/content/corner-br.gif') }});"></div></div>
</div>