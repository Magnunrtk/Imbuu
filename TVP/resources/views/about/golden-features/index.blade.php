@extends('layout')
@section('title', 'Golden account features')
@section('content')
    <h2>Why buy Golden Account?</h2>
    <p>
        {{ config('server.serverName') }} is free, and players are welcome to play free of charge for as long as they like. However, if you enjoy {{ config('server.serverName') }},
        you may consider buying a Golden Account to take your game even further. As a premium player you will have additional abilities
        and advantages inside as well as outside the game. <a href="{{ route('about.golden-features') }}">Buying a Golden Account</a> allows us to maintain
        game worlds of {{ config('server.serverName') }} and develop new features to make it even more fun!
    </p>
    <div class="panel mb-4 mt-4">
        <div class="panel__title">Golden Account Features</div>
        <table class="panel__table table table--vertical-top">
            <tbody>
            <tr class="table__row">
                <td class="table__cell" style="width:25%;vertical-align:middle;">Loot Messages</td>
                <td class="table__cell">Premium players don't need to open every dead corpse to see the look as loot messages automatically pop up on screen.</td>
            </tr>
            <tr class="table__row">
                <td class="table__cell" style="vertical-align:middle;">Experience</td>
                <td class="table__cell">You get <strong>10%</strong> more experience.</td>
            </tr>
            <tr class="table__row">
                <td class="table__cell" style="vertical-align:middle;">Rashid Trade</td>
                <td class="table__cell">Only premium players are allowed to trade with travelling seller called <strong>Rashid</strong>. Meet him in various {{ config('server.serverName') }} cities.</td>
            </tr>
            <tr class="table__row">
                <td class="table__cell" style="vertical-align:middle;">Depot Limits</td>
                <td class="table__cell">As a golden account you will be able to hold <strong>twice</strong> (30,000) as many items in your depot than before!</td>
            </tr>
            <tr class="table__row">
                <td class="table__cell" colspan="2" style="font-size:15px;font-weight:500;text-align:center;">There are even more premium features! Find every new aspect of golden account for yourself!</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="row justify-content-center">
        <div class="col-3">
            <a href="#" class="btn btn--block btn-primary">
                Premium Store
            </a>
        </div>
    </div>
@endsection