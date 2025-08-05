@extends('template.layout')
@section('title', 'Rarity Upgrade')
@section('submenuItem', 'rarityUpgrade')
@section('content')

<h2>Rarity Upgrade</h2>

<p>
    The <strong>Rarity Upgrade</strong> system allows you to add attributes to items that don't have any, or enhance those that already do. Attributes are generated randomly, and an item can have a maximum of 4 attributes, reaching the <strong>Legendary</strong> status.
</p>

<h3>How does it work?</h3>

<ul>
    <li><strong>Orbs</strong> are extracted from items with attributes using an <strong>Orb Extractor</strong>.</li>
    <li>The <strong>Orb Extractor</strong> can be dropped by creatures, purchased from an NPC, or acquired in the <strong>Game Store</strong>.</li>
    <li>Orbs are divided into <strong>tiers</strong> (1 to 4) and can only be used on items of the same tier.</li>
    <li>When applying an Orb to an item, there is a chance of <strong>success</strong>, <strong>failure</strong>, and a small chance of <strong>breaking the item</strong> and losing it.</li>
    <li>The rarer the item, the <strong>lower the success rate</strong> and the <strong>higher the risk of breaking</strong> it.</li>
    <li>There is an NPC that allows you to trade multiple lower-tier Orbs for a higher-tier one.</li>
    <li>For each upgrade attempt, your character must have the following amount of gold in the <strong>main backpack</strong>:</li>
</ul>

@php
    $upgradeData = [
        [
            'tier' => 'Tier 1',
            'orbName' => 'Faintlight Orb',
            'orbImage' => 't1.png',
            'costs' => ['1,250K', '2.5K', '3.75K', '5K'],
        ],
        [
            'tier' => 'Tier 2',
            'orbName' => 'Tidebound Orb',
            'orbImage' => 't2.png',
            'costs' => ['2.5K', '5K', '7.5K', '10K'],
        ],
        [
            'tier' => 'Tier 3',
            'orbName' => 'Netherbound Orb',
            'orbImage' => 't3.png',
            'costs' => ['5K', '10K', '15K', '20K'],
        ],
        [
            'tier' => 'Tier 4',
            'orbName' => 'Blazefury Orb',
            'orbImage' => 't4.png',
            'costs' => ['10K', '20K', '30K', '40K'],
        ],
    ];
@endphp

<h4>Upgrade Costs by Tier</h4>

<table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
  <thead>
    <tr>
      <th style="border: 1px solid #ccc; padding: 4px;">Image</th>
      <th style="border: 1px solid #ccc; padding: 4px;">Orb</th>
      <th style="border: 1px solid #ccc; padding: 4px;">Item Tier</th>
      <th style="border: 1px solid #ccc; padding: 4px;">Common → Uncommon</th>
      <th style="border: 1px solid #ccc; padding: 4px;">Uncommon → Rare</th>
      <th style="border: 1px solid #ccc; padding: 4px;">Rare → Epic</th>
      <th style="border: 1px solid #ccc; padding: 4px;">Epic → Legendary</th>
    </tr>
  </thead>
  <tbody>
    @foreach($upgradeData as $data)
      <tr class="{{ $loop->odd ? 'odd' : 'even' }}">
        <td style="border: 1px solid #faf0d7; padding: 4px; text-align: center;">
          <img src="/images/orbs/{{ $data['orbImage'] }}" alt="{{ $data['orbName'] }}" style="width: 32px;">
        </td>
        <td style="border: 1px solid #faf0d7; padding: 4px;">{{ $data['orbName'] }}</td>
        <td style="border: 1px solid #faf0d7; padding: 4px;">{{ $data['tier'] }}</td>
        @foreach($data['costs'] as $cost)
          <td style="border: 1px solid #faf0d7; padding: 4px;">{{ $cost }}</td>
        @endforeach
      </tr>
    @endforeach
  </tbody>
</table>

<h3>Upgrade Outcomes</h3>

<div style="display: flex; gap: 40px;">
  <!-- Primeiro bloco -->
  <div style="display: grid; grid-template-columns: 172px 1fr; gap: 20px; align-items: start;">
      <img src="/images/orbs/aplicandoRaridade.gif" alt="Applying Orb" width="172" height="172" style="border-radius: 4px;">
      <div>
          <h4 style="margin: 0;">Applying an Orb</h4>
          <p style="margin: 5px 0 0; width: 200px; text-align: justify;">
            When an Orb is applied to an item, there's a chance of success, failure, or item destruction. 
            The process is random and the outcome depends on the item's current rarity tier.
          </p>
      </div>
  </div>

  <!-- Segundo bloco -->
  <div style="display: grid; grid-template-columns: 172px 1fr; gap: 20px; align-items: start;">
      <img src="/images/orbs/quebrandoRaridade.gif" alt="Item Break" width="172" height="172" style="border-radius: 4px;">
      <div>
          <h4 style="margin: 0;">Item Break Chance</h4>
          <p style="margin: 5px 0 0; width: 200px; text-align: justify;">
            If an upgrade fails critically, the item might be destroyed. This chance increases with higher rarity levels,
            making the upgrade process risky but rewarding.
          </p>
      </div>
  </div>
</div>


<h3>Orb Extractors</h3>

<p>Extractors are used to remove Orbs from enchanted items. They are essential tools in the rarity upgrade system.</p>

<div style="display: flex; gap: 40px; margin-top: 15px;">
    <div style="text-align: center;">
        <img src="/images/orbs/orbExtractor.png" alt="Orb Extractor">
        <p><strong>Orb Extractor</strong><br><small>50% chance of breaking</small></p>
    </div>
    <div style="text-align: center;">
        <img src="/images/orbs/perfectOrbExtractor.png" alt="Perfect Orb Extractor">
        <p><strong>Perfect Orb Extractor</strong><br><small>No chance of breaking</small></p>
    </div>
</div>

@endsection
