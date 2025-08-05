@extends('template.layout')

@section('title', 'Latest News')
@section('submenuItem', 'latestnews')

@section('news-content')
    @if(!$newsTicker->isEmpty())
        @include('news.boxes.news-ticker', $newsTicker)
    @endif
@endsection

@section('content')

    <style>

        .promo-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); 
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            visibility: hidden; 
            opacity: 0; 
            transition: visibility 0s, opacity 0.3s linear;
        }

        .promo-overlay.active {
            visibility: visible; 
            opacity: 1; 
        }

        .promo-content {
            position: relative;
            background-color: white;
            border-radius: 5px;
            border: 2px solid white; 
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5); 
            max-width: 80%; 
            max-height: 80%; 
            overflow: hidden;
        }

        .promo-image {
            width: 100%;
            height: auto;
            object-fit: cover; 
            max-width: 100%;
            max-height: 70vh; 
        }

        .promo-close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            color: #333;
            text-decoration: none;
            background: transparent;
            border: none;
            cursor: pointer;
        }

        .promo-close:hover {
            opacity: 0.5;
        }

        .promo-close img {
            width: 30px; 
            height: auto;
        }

    </style>

    <div id="promoOverlay" class="promo-overlay" onclick="closePromo()">
        <div class="promo-content" onclick="event.stopPropagation();">
            <a href="/account/store/packages">
                <img src="{{ asset('/pacotes.png') }}?v=a1" alt="Pacotes Promo" class="promo-image">
            </a>
            <a href="#" class="promo-close" onclick="closePromo()">
                <img src="{{ asset('/closex.png') }}" alt="Fechar" >
            </a>
        </div>
    </div>

    <script>

        function openPromo() {
            const promoOverlay = document.getElementById('promoOverlay');
            promoOverlay.classList.add('active'); 
        }

        function closePromo() {
            const promoOverlay = document.getElementById('promoOverlay');
            promoOverlay.classList.remove('active'); 
        }

        window.onload = function() {
            openPromo();
        }
    </script>

    <style>

        .countdown-card {
            background-color: #141b46;
            border-radius: 5px;
            padding: 10px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .countdown {
            font-weight: bold;
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 40px 0;
            padding-top: 10px;
        }

        .countdownH {
            text-align: center;
            display: block;
            font-size: 3em;
            margin-bottom: 10px;
        }

        .countdown-title {
            font-family: 'Martel', serif;
            color: #8B4513; /* brown */
            font-size: 2.5em;
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

    </style>
{{-- 
    <h1 class="countdown-title">Official opening in</h1>

    <div id="countdown" class="countdown">
        <div class="countdown-card" id="days">
            <span>29</span>
            <div class="countdown-label">Days</div>
        </div>
        <div class="countdown-card" id="hours">
            <span>2</span>
            <div class="countdown-label">Hours</div>
        </div>
        <div class="countdown-card" id="minutes">
            <span>24</span>
            <div class="countdown-label">Minutes</div>
        </div>
        <div class="countdown-card" id="seconds">
            <span>22</span>
            <div class="countdown-label">Seconds</div>
        </div>
    </div>

    <script>
    // Set the date were counting down to
    var countDownDate = new Date("June 29, 2025 16:00:00 GMT-0300").getTime();

    // Update the count down every second
    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;

        document.getElementById("days").firstElementChild.innerText = Math.floor(distance / (1000 * 60 * 60 * 24));
        document.getElementById("hours").firstElementChild.innerText = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        document.getElementById("minutes").firstElementChild.innerText = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        document.getElementById("seconds").firstElementChild.innerText = Math.floor((distance % (1000 * 60)) / 1000);

        if (distance < 0) {
        clearInterval(x);
        document.getElementById("countdown").className = "hidden";
        }
    }, 1000);
    </script> --}}

    @foreach($allNews as $news)
        <div class="NewsHeadline">
            <div class="NewsHeadlineBackground" style="background-image:url({{ asset('/assets/tibiarl/images/content/info-background.gif') }})">
                <img src="{{ asset('/assets/tibiarl/images/news/newsicon_'. $news->category .'.gif') }}" class="NewsHeadlineIcon" alt="">
                <div class="NewsHeadlineDate">{{ date('M d Y', strtotime($news->created_at)) }} - </div>
                <div class="NewsHeadlineText">{{ $news->title }}</div>
            </div>
        </div>
        <table class="NewsTable" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td class="NewsTableContainer">
                    <p>{!! $news->body !!}</p>
                </td>
            </tr>
            </tbody>
        </table>
        <br>
    @endforeach
@endsection

{{-- @section('scripts')
    <script>

        function openPromo() {
            const promoOverlay = document.getElementById('promoOverlay');
            promoOverlay.classList.add('active'); 
        }

        function closePromo() {
            const promoOverlay = document.getElementById('promoOverlay');
            promoOverlay.classList.remove('active'); 
        }

        window.onload = function() {
            openPromo();
        }
    </script>
@endsection --}}
