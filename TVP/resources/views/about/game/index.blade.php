@extends('template.layout')
@section('title', 'What is ' . config('server.serverName'))
@section('submenuItem', 'about')
@section('content')
    <p>
        <b>{{ config('server.serverName') }}</b> is a custom real map old school gaming server, mainly created for those who love the atmosphere and gameplay of the past, yet still nostalgic and fascinating version 7.4. In an MMORPG people from all over the world meet on a virtual playground to explore areas, solve tricky riddles and undertake heroic exploits.
    </p>
    <p>
        We invite you to visit the medieval world of {{ config('server.serverName') }}. Begin your journey and join players from all over the world to enjoying the numerous <a href="{{ route('about.game-features') }}">game features</a>.
    </p>
    <p>
        Acting as knights, paladins, sorcerers or druids, players are faced with the challenge of developing the skills of their selected characters, exploring a large variety of areas and dangerous dungeons and interacting with other players on a social and diplomatic level. Besides the sophisticated chat tools, and our Discord, it is especially the unique freedom players enjoy in {{ config('server.serverName') }}, that create an enormously immersive gaming experience.
    </p>
    <p>
        {{ config('server.serverName') }} can be played free of charge as a matter of principle. However, the game can be upgraded anytime to a <a href="{{ route('about.premium-features') }}">Premium Account</a>. Advantages of Premium Accounts include the access to special game areas and items as well as further special features relating to the gameplay.
    </p>
    <p>
        A great team, consisting of our Staff, ensures that players can enjoy {{ config('server.serverName') }}. We and our own players answer questions from unexperienced players in the help channel. Our Gamemasters enforce the {{ config('server.serverName') }} Rules, a special code of conduct that determines what players are allowed to do in the game and what not.
    </p>
@endsection