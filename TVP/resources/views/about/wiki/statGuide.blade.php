@extends('template.layout')
@section('title', 'Stat Guide')
@section('submenuItem', 'statGuide')
@section('content')


    <style>
        #attribute-table th,
        #attribute-table td {
            border: 1px solid #faf0d7;
        }
    </style>

    <h2>Level Tiers</h2>

    <p>
        Each tier is subdivided by item rarity, from <strong>Uncommon</strong> to <strong>Legendary</strong>, and each step requires reaching a specific character level. Unlocking higher-tier gear allows adventurers to face tougher enemies and explore more dangerous regions of the world with greater efficiency.
    </p>

    <p>
        Below is a breakdown of the required levels for each tier:
    </p>

    <table id="attribute-table" cellpadding="6" cellspacing="0" style="width: 100%">
        <thead>
            <tr>
                <th>Tier</th>
                <th>Uncommon</th>
                <th>Rare</th>
                <th>Epic</th>
                <th>Legendary</th>
            </tr>
        </thead>
        <tbody>
            <tr class="Odd">
                <td>Tier 1</td>
                <td>Level 10</td>
                <td>Level 10</td>
                <td>Level 10</td>
                <td>Level 10</td>
            </tr>
            <tr class="Even">
                <td>Tier 2</td>
                <td>Level 15</td>
                <td>Level 20</td>
                <td>Level 25</td>
                <td>Level 30</td>
            </tr>
            <tr class="Odd">
                <td>Tier 3</td>
                <td>Level 35</td>
                <td>Level 40</td>
                <td>Level 45</td>
                <td>Level 50</td>
            </tr>
            <tr class="Even">
                <td>Tier 4</td>
                <td>Level 55</td>
                <td>Level 60</td>
                <td>Level 65</td>
                <td>Level 70</td>
            </tr>
        </tbody>
    </table>

    <br>

    <h2>Item Attributes</h2>

    <p>
        Items in the game can be enhanced with a variety of <strong>attributes</strong> that grant additional effects or bonuses to your character. These attributes are bound to specific item types and can significantly impact your combat performance, defense, mobility, and utility.
    </p>

    <p>
        Attribute is designed to suit different playstyles and vocations.
    </p>

    <p>
        Below is a list of all available attributes, along with the vocations that can use them, the applicable item types, and the specific effects they provide:
    </p>

    <table id="attribute-table" cellpadding="6" cellspacing="0">
        <thead>
        <tr>
            <th>Attribute Name</th>
            <th>Vocations</th>
            <th>Item Type</th>
            <th>Application</th>
        </tr>
        </thead>
        <tbody id="attributeTableBody">
        </tbody>
    </table>
  
    <script src="{{ asset('assets/tibiarl/js/about/wiki/statGuide.min.js') }}?v=2" defer></script>

@endsection
