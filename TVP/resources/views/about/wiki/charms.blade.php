@extends('template.layout')
@section('title', 'Charms')
@section('submenuItem', 'charms')
@section('content')

<h2>Charm System</h2>

<p>
  <strong>Charm Runes</strong> are bonuses that can be acquired by spending <strong>Charm Points</strong>, helping you during battles against specific selected creatures.
</p>

<ul>
  <li>You can select only <strong>1 Charm Rune</strong> per creature.</li>
  <li>To select up to <strong>3 different Charm Runes</strong> for different creatures, you need to purchase <strong>Extra Charm Slots</strong> from the Store.</li>
  <li>To swap or assign a creature to your Charm Rune, you must pay a gold fee based on your character's level.</li>
</ul>

<h3>Charm Points</h3>

<p>
  Charm Points are earned every time you complete a stage of a creature's <strong>Bestiary</strong>.
</p>

<ul>
  <li>The number of points earned varies depending on the creature's difficulty.</li>
</ul>


<h2>Charm Effects</h2>

@php
    $charms = [
        [
            'name' => 'Wound',
            'cost' => 1600,
            'desc' => 'Each <strong>attack</strong> on a creature has a <strong>4% chance</strong> to trigger and deal <strong>5%</strong> of its maximum HP as <strong>Physical Damage</strong> once.'
        ],
        [
            'name' => 'Enflame',
            'cost' => 1600,
            'desc' => 'Each <strong>attack</strong> on a creature has a <strong>4% chance</strong> to trigger and deal <strong>5%</strong> of its maximum HP as <strong>Fire Damage</strong> once.'
        ],
        [
            'name' => 'Zap',
            'cost' => 1600,
            'desc' => 'Each <strong>attack</strong> on a creature has a <strong>4% chance</strong> to trigger and deal <strong>5%</strong> of its maximum HP as <strong>Energy Damage</strong> once.'
        ],
        [
            'name' => 'Poison',
            'cost' => 1600,
            'desc' => 'Each <strong>attack</strong> on a creature has a <strong>4% chance</strong> to trigger and deal <strong>5%</strong> of its maximum HP as <strong>Poison Damage</strong> once.'
        ],
        [
            'name' => 'Adrenaline Burst',
            'cost' => 1600,
            'desc' => 'Bursts of adrenaline enhance your <strong>reflexes</strong> with a <strong>4% chance</strong> after getting hit and lets you <strong>move faster</strong> for <strong>10 seconds</strong>.'
        ],
        [
            'name' => 'Dodge',
            'cost' => 1600,
            'desc' => 'Dodges an attack with a <strong>4% chance</strong>, taking <strong>no damage</strong> at all.'
        ],
        [
            'name' => 'Numb',
            'cost' => 1600,
            'desc' => 'Numbs the creature with a <strong>4% chance</strong> after its attack and <strong>paralyses</strong> the creature for <strong>10 seconds</strong>.'
        ],
        [
            'name' => 'Parry',
            'cost' => 1600,
            'desc' => 'Any <strong>physical damage</strong> taken has a <strong>4% chance</strong> to be <strong>reflected</strong> to the aggressor as Physical Damage.'
        ],
        [
            'name' => 'Low Blow',
            'cost' => 2200,
            'desc' => 'Adds <strong>4% critical hit chance</strong> to attacks.'
        ],
    ];
@endphp

<table style="width: 100%; border-collapse: collapse;">
  <thead>
    <tr>
      <th style="border: 1px solid #ccc; padding: 8px;">Icon</th>
      <th style="border: 1px solid #ccc; padding: 8px;">Name</th>
      <th style="border: 1px solid #ccc; padding: 8px;">Description</th>
      <th style="border: 1px solid #ccc; padding: 8px;">Charm Point Cost</th>
    </tr>
  </thead>
  <tbody>
    @foreach($charms as $charm)
        <tr class="{{ $loop->odd ? 'odd' : 'even' }}">
        <td style="border: 1px solid  #faf0d7; padding: 8px;">
            <img src="{{ asset('images/charms_images/' . $charm['name'] . '.png') }}" alt="{{ $charm['name'] }}" style="width: 32px; height: 32px;">
        </td>
        <td style="border: 1px solid  #faf0d7; padding: 8px;">{{ $charm['name'] }}</td>
        <td style="border: 1px solid  #faf0d7; padding: 8px;">{!! $charm['desc'] !!}</td>
        <td style="border: 1px solid  #faf0d7; padding: 8px;">{{ $charm['cost'] }}</td>
        </tr>
    @endforeach  
  </tbody>
</table>

@endsection
