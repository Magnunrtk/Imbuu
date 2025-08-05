@extends('template.layout')
@section('title', 'Market Offline')
@section('submenuItem', 'marketOffline')
@section('content')

<h2>Market Offline</h2>

<p>
  The <strong>Offline Market</strong> allows players to sell their equipment and supplies even while being disconnected from the game.
</p>

<h3>How does it work?</h3>

<ul>
  <li>You must first purchase a temporary <strong>Market License</strong> from the in-game Store to be able to sell through the Offline Market.</li>
  <li>The market can only be activated in specific locations within each city.</li>
  <li>To open the market, go to one of these spots, right-click yourself, and choose <strong>Open Market</strong>.</li>

  <div style="text-align: center">
    <img src="/images/marketOffline/abrindoMarket.gif" alt="Opening Market" width="450" height="450" style="margin: 10px 0; border-radius: 4px; border: 2px solid #231147;">
  </div>


  <li>You may write a short description (up to 40 characters) following Ravenor’s naming rules.</li>
  <li>You must place the items you wish to sell in your <strong>main backpack</strong>.</li>
  <li>Select the items and set the price for each.</li>

  <div style="text-align: center">
    <img src="/images/marketOffline/adicionandoItemMarket.gif" alt="Adding Item to Market" width="450" height="450" style="margin: 10px 0; border-radius: 4px; border: 2px solid #231147;">
  </div>

  <li>Once added to the market, the items are removed from your backpack and can only be retrieved at market locations.</li>
  <li>Only <strong>Runes</strong>, <strong>Ammunition</strong>, and <strong>Food</strong> items are allowed inside backpacks for sale.</li>
  <li>Backpacks must contain only <strong>identical items</strong>.</li>
  <li>You cannot start the market if other players are nearby.</li>

  <li>When starting your market, your character will be automatically disconnected from the game.</li>

  <div style="text-align: center">
    <img src="/images/marketOffline/ativandoMarket.gif" alt="Activating Market" width="450" height="450" style="margin: 10px 0; border-radius: 4px; border: 2px solid #231147;">
  </div>

  <li>Gold from sold items is automatically sent to your character upon your next login.</li>
  <li>The purchased item is instantly transferred to the buyer.</li>

  <div style="text-align: center">
    <img src="/images/marketOffline/marketAtivo.gif" alt="Market Active" width="450" height="450" style="margin: 20px 0; border-radius: 4px; border: 2px solid #231147;">
  </div>
</ul>

@endsection
