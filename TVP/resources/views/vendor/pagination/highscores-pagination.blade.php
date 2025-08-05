@if ($paginator->hasPages())
    <small>
        <div style="float: left;">
            <b>» Pages:
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="PageLink ">
                            <span class="CurrentPageLink">{{ $element }}</span>
                        </span>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="PageLink ">
                            <span class="CurrentPageLink">{{ $page }}</span>
                        </span>
                            @else
                                <span class="PageLink">
                            <a href="{{ $baseUrl }}/{{ $skill_url }}/{{ preg_replace('/[^0-9]/', '', $url) }}@if($vocation !== 'all')/{{ $vocation }}@endif">{{ $page }}</a>
                        </span>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </b>
        </div>
        <div style="float: right;">
            <b>» Results: {{ number_format(config('highscore.listLimit')) }}</b>
        </div>
    </small>
@endif
