<?php

class AdditionalNames {

    private static $names = [
        'absorbpercentphysical' => ['Protection Physical', '%'], 
        'absorbpercentfire' => ['Protection Fire', '%'], 
        'absorbpercentpoison' => ['Protection Poison', '%'], 
        'absorbpercentenergy' => ['Protection Energy', '%'], 
        'absorbpercentmanadrain' => ['Protection Mana Drain', '%'], 
        'absorbpercentlifedrain' => ['Protection Life Drain', '%'], 
        'duration' => ['Duration Time', 's'], 
        'charges' => ['Uses', ''], 
        'desc' => ['', ''], 
        'skillfist' => ['Skill Fist', ''], 
        'skillaxe' => ['Skill Axe', ''], 
        'skillsword' => ['Skill Sword', ''], 
        'skillclub' => ['Skill Club', ''], 
        'manashield' => ['Give Mana Shield', ''], 
        'suppressdrunk' => ['Suppress Drunk', ''], 
        'healthgain' => ['Health Gain', ''], 
        'healthticks' => ['Health Ticks', ''], 
        'managain' => ['Mana Gain', ''], 
        'manaticks' => ['Mana Ticks', ''], 
        'invisible' => ['Make you Invisible', '']
    ];

    private static $tiers = [
        'one-handed' => [
            ['max_attack' => 31, 'tier' => 1],
            ['max_attack' => 35, 'tier' => 2],
            ['max_attack' => 39, 'tier' => 3],
            ['max_attack' => PHP_INT_MAX, 'tier' => 4],
        ],
        'two-handed' => [
            ['max_attack' => 44, 'tier' => 1],
            ['max_attack' => 49, 'tier' => 2],
            ['max_attack' => 59, 'tier' => 3],
            ['max_attack' => PHP_INT_MAX, 'tier' => 4],
        ],
        'distance-one-handed' => [
            ['max_attack' => 31, 'tier' => 1],
            ['max_attack' => 35, 'tier' => 2],
            ['max_attack' => 39, 'tier' => 3],
            ['max_attack' => PHP_INT_MAX, 'tier' => 4],
        ],
        'distance-two-handed' => [
            ['max_attack' => 0, 'tier' => 1],
            ['max_attack' => 1, 'tier' => 2],
            ['max_attack' => 3, 'tier' => 3],
            ['max_attack' => PHP_INT_MAX, 'tier' => 4],
        ],
        'head' => [
            ['max_armor' => 6, 'tier' => 1],
            ['max_armor' => 8, 'tier' => 2],
            ['max_armor' => 10, 'tier' => 3],
            ['max_armor' => PHP_INT_MAX, 'tier' => 4],
        ],
        'body' => [
            ['max_armor' => 10, 'tier' => 1],
            ['max_armor' => 13, 'tier' => 2],
            ['max_armor' => 15, 'tier' => 3],
            ['max_armor' => PHP_INT_MAX, 'tier' => 4],
        ],
        'legs' => [
            ['max_armor' => 7, 'tier' => 1],
            ['max_armor' => 8, 'tier' => 2],
            ['max_armor' => 9, 'tier' => 3],
            ['max_armor' => PHP_INT_MAX, 'tier' => 4],
        ],
        'feet' => [
            ['max_armor' => 1, 'tier' => 1],
            ['max_armor' => 2, 'tier' => 2],
            ['max_armor' => 3, 'tier' => 3],
            ['max_armor' => PHP_INT_MAX, 'tier' => 4],
        ],
        'shield' => [
            ['max_defense' => 29, 'tier' => 1],
            ['max_defense' => 33, 'tier' => 2],
            ['max_defense' => 35, 'tier' => 3],
            ['max_defense' => PHP_INT_MAX, 'tier' => 4],
        ],
    ];

    public static function get($key) {
        return self::$names[$key] ?? null;
    }

    public static function getAll() {
        return self::$names;
    }

    public static function formatAttributes($attributes) {
        $formatted = '';

        foreach ($attributes as $key => $value) {

            if (isset(self::$names[$key])) {
                [$name, $suffix] = self::$names[$key];
                
                $value = intval($value);

                if (!empty($name)) {

                    if ($key === 'duration') {
                        $value = number_format($value / 60);
                        $suffix = ' Min'; 
                    }

                    if($key == "healthticks" || $key == "manaticks") continue;
    
                    if ($key === 'charges') {
                        $formatted .= "Has $value $name<br>"; 

                    }elseif($value < 1 || $key == "manashield"){

                        $formatted .= "$name<br>";

                    }elseif($key == "managain"){

                        $formatted .= "+$value$suffix $name / ". $attributes['manaticks'] / 1000 . " Secs<br>";

                    }elseif($key == "healthgain"){

                        $formatted .= "+$value$suffix $name / ". $attributes['healthticks'] / 1000 . " Secs<br>";

                    }else {
         
                        $formatted .= "+$value$suffix $name<br>";
                    }
                }
            }
        }
        
        return $formatted;
    }

    public static function getTier($item) {
        $tier = 1;
        $maxValue = 0;
        $itemType = null;

        if (isset($item['attributes']['slottype']) && !isset($item['attributes']['weapontype'])) {

            $itemType = strtolower($item['attributes']['slottype']);
            $maxValue = $item['attributes']['armor'] ?? 0; 

        } elseif (isset($item['attributes']['weapontype'])) {

            if(isset($item['attributes']['slottype'])){
                $itemType = "two-handed";
            }else{
                $itemType = "one-handed";
            }

            $maxValue = $item['attributes']['attack'] ?? 0;

        } else {

            return $tier; 
        }

        if (isset($item['attributes']['weapontype']) && $item['attributes']['weapontype'] == "shield") {

            $itemType = "shield";
            $maxValue = $item['attributes']['defense'] ?? 0; 

            if (isset(self::$tiers[$itemType])) {
                foreach (self::$tiers[$itemType] as $tierRange) {
                    if (isset($tierRange['max_defense']) && $maxValue <= $tierRange['max_defense']) {
                        $tier = $tierRange['tier'];
                        break;
                    }
                }
            }

        } elseif (isset(self::$tiers[$itemType])) {

            foreach (self::$tiers[$itemType] as $tierRange) {

                if (isset($tierRange['max_armor']) && $maxValue <= $tierRange['max_armor']) {
                    $tier = $tierRange['tier'];
                    break;
                } elseif (isset($tierRange['max_attack']) && $maxValue <= $tierRange['max_attack']) {
                    $tier = $tierRange['tier'];
                    break;
                }

            }
        }
    
        return $tier;
    }    
}

function generateArmorsRow($item, $serverPath, $toggleClass, $nameFormatted) {

    $excludedItems = [
        'Boots Of Waterwalking',
        'Soft Boots'
    ];

    if (in_array($nameFormatted, $excludedItems)) {
        return '';
    }

    if ($nameFormatted === "Helmet Of The Ancients"){
        $item["attributes"]['clientid'] = 3229;
        $item["attributes"]['armor'] = 8; 
        $item["attributes"]['weight'] = 2760;
        $item["attributes"]['raritytier'] = 4;
    }; 
    
    $tier = $item["attributes"]['raritytier'] ?? AdditionalNames::getTier($item);
    $weight = isset($item["attributes"]['weight']) ? number_format($item["attributes"]['weight'] / 100, 2) : "0.00";
    $armor = $item['attributes']['armor'] ?? "0";
    $color = ($tier >= 2 && $tier <= 4) ? ["#FF4D4D", "#E60000", "#990000"][$tier - 2] : "#FF9999";
    $attributeDetails = $nameFormatted === "Helmet Of The Ancients" ? '' : AdditionalNames::formatAttributes($item['attributes']);

    return "
        <tr class='rowPage $toggleClass'>
            <td><img src='$serverPath/items/". $item["attributes"]['clientid'] .".gif'></td>
            <td data-column='name'><a href='/about/itemPage/" . urlencode(strtolower($nameFormatted)) . "'><span>" . ucwords(strtolower($nameFormatted)) . "</span></a></td>
            <td data-column='weight'>$weight oz</td>
            <td data-column='armor'>$armor</td>
            <td style='color: $color; text-shadow: 0px 0px 1px #000000;' data-column='tier'>$tier</td>
            <td>$attributeDetails</td>
        </tr>";
}

function generateShieldsRow($item, $serverPath, $toggleClass, $nameFormatted) {

    $tier = $item["attributes"]['raritytier'] ?? AdditionalNames::getTier($item);
    $weight = isset($item["attributes"]['weight']) ? number_format($item["attributes"]['weight'] / 100, 2) : "0.00";
    $armor = $item['attributes']['defense'] ?? "0";
    $color = ($tier >= 2 && $tier <= 4) ? ["#FF4D4D", "#E60000", "#990000"][$tier - 2] : "#FF9999";
    $attributeDetails = AdditionalNames::formatAttributes($item['attributes']);

    return "
        <tr class='rowPage $toggleClass'>
            <td><img src='$serverPath/items/". $item["attributes"]['clientid'] .".gif'></td>
            <td data-column='name'><a href='/about/itemPage/" . urlencode(strtolower($nameFormatted)) . "'><span>" . ucwords(strtolower($nameFormatted)) . "</span></a></td>
            <td data-column='weight'>$weight oz</td>
            <td data-column='armor'>$armor</td>
            <td style='color: $color; text-shadow: 0px 0px 1px #000000;' data-column='tier'>$tier</td>
            <td>$attributeDetails</td>
        </tr>";
}

function generateWeaponsRow($item, $serverPath, $toggleClass, $nameFormatted) {

    $hands = "One";
    $colorHands = "rgb(192, 14, 14)";

    if (isset($item['attributes']['slottype'])) {
        if (strtolower($item['attributes']['slottype']) === 'two-handed') {
            $hands = 'Two';
            $colorHands = "rgb(14, 192, 109)";
        }
    }

    $tier = $item["attributes"]['raritytier'] ?? AdditionalNames::getTier($item);
    $weight = isset($item["attributes"]['weight']) ? number_format($item["attributes"]['weight'] / 100, 2) : "0.00";
    $attack = $item['attributes']['attack'] ?? "0";
    $armor = $item['attributes']['defense'] ?? "0";
    $color = ($tier >= 2 && $tier <= 4) ? ["#FF4D4D", "#E60000", "#990000"][$tier - 2] : "#FF9999";
    $attributeDetails = AdditionalNames::formatAttributes($item['attributes']);

    return "
        <tr class='rowPage $toggleClass'>
            <td><img src='$serverPath/items/". $item["attributes"]['clientid'] .".gif'></td>
            <td data-column='name'><a href='/about/itemPage/" . urlencode(strtolower($nameFormatted)) . "'><span>" . ucwords(strtolower($nameFormatted)) . "</span></a></td>
            <td data-column='attack'>$attack</td>
            <td data-column='armor'>$armor</td>
            <td style='color: $colorHands'>$hands</td>
            <td style='color: $color; text-shadow: 0px 0px 1px #000000;' data-column='tier'>$tier</td>
            <td>$attributeDetails</td>
                        <td data-column='weight'>$weight oz</td>
        </tr>";
}

function generateWandsRow($item, $serverPath, $toggleClass, $nameFormatted) {

    $tier = 1;
    $rarityTier = "";

    if (isset($item["attributes"]['raritytier'])) {
        $rarityTier = $tier = $item["attributes"]['raritytier'];
    }

    $color = ($tier >= 2 && $tier <= 4) ? ["#FF4D4D", "#E60000", "#990000"][$tier - 2] : "#FF9999";

    $magicLevel = isset($item["attributes"]['magicpoints']) ? $item["attributes"]['magicpoints'] : 0;
    $nameFormatted = $item['name'] ?? "Unknown Item";
    $weight = isset($item["attributes"]['weight']) ? number_format($item["attributes"]['weight'] / 100, 2) : "0.00";

    return "
        <tr class='rowPage $toggleClass'>
            <td><img src='{$serverPath}/items/". $item["attributes"]['clientid'] .".gif'></td>
            <td data-column='name'><a href='/about/itemPage/" . urlencode(strtolower($nameFormatted)) . "'><span>" . ucwords(strtolower($nameFormatted)) . "</span></a></td>
            <td data-column='weight'>$weight oz</td>
            <td style='color: $color; text-shadow: 0px 0px 1px #000000;' data-column='tier'>$tier</td>
            <td>+$magicLevel Magic Level</td>
        </tr>
    ";
}

function generateThrowingWeaponsRow($item, $serverPath, $toggleClass, $nameFormatted) {

    $weight = isset($item["attributes"]['weight']) ? number_format($item["attributes"]['weight'] / 100, 2) : "0.00";
    $range = $item['attributes']['range'] ?? "";
    $tier = $item['attributes']['raritytier'] ?? "1"; 

    $color = ($tier >= 2 && $tier <= 4) ? ["#FF4D4D", "#E60000", "#990000"][$tier - 2] : "#FF9999";

    return "
        <tr class='rowPage $toggleClass'>
            <td><img src='$serverPath/items/". $item["attributes"]['clientid'] .".gif'></td>
            <td data-column='name'><a href='/about/itemPage/" . urlencode(strtolower($nameFormatted)) . "'><span>" . ucwords(strtolower($nameFormatted)) . "</span></a></td>
            <td>$range</td>
            <td style='color: rgb(192, 14, 14);'>One</td>
            <td data-column='weight'>$weight oz</td>
        </tr>";
}

function generateCrossbowRow($item, $serverPath, $toggleClass, $nameFormatted) {

    $rarityTier = isset($item["attributes"]['raritytier']) ? $item["attributes"]['raritytier'] : "";
    $weight = isset($item["attributes"]['weight']) ? number_format($item["attributes"]['weight'] / 100, 2) : "0.00";
    $slottype = isset($item['attributes']['slottype']) ? ($item['attributes']['slottype'] ? "Two" : "One") : "One";
    $ammoType = isset($item['attributes']['ammotype']) ? $item['attributes']['ammotype'] : "";
    $range = isset($item['attributes']['range']) ? $item['attributes']['range'] : "";
    $tier = isset($item['attributes']['raritytier']) ? $item['attributes']['raritytier'] : "1";

    $colorHands = "rgb(192, 14, 14)";

    if (isset($item['attributes']['slottype'])) {
        if (strtolower($item['attributes']['slottype']) === 'two-handed') {
            $hands = 'Two';
            $colorHands = "rgb(14, 192, 109)";
        }
    }

    $color = ($tier >= 2 && $tier <= 4) ? ["#FF4D4D", "#E60000", "#990000"][$tier - 2] : "#FF9999";

    return "
        <tr class='rowPage $toggleClass'>
            <td><img src='$serverPath/items/". $item["attributes"]['clientid'] .".gif'></td>
            <td data-column='name'><a href='/about/itemPage/" . urlencode(strtolower($nameFormatted)) . "'><span>" . ucwords(strtolower($nameFormatted)) . "</span></a></td>
            <td>$range</td>
            <td style='color: $colorHands'>$slottype</td>
            <td>$ammoType</td>
            <td style='color: $color; text-shadow: 0px 0px 1px #000000;' data-column='tier'>$tier</td>
            <td></td>
            <td data-column='weight'>$weight oz</td>
        </tr>";
}

function generateBowQuiverRow($item, $serverPath, $toggleClass, $nameFormatted) {

    $weight = isset($item["attributes"]['weight']) ? number_format($item["attributes"]['weight'] / 100, 2) : "0.00";
    $range = $item['attributes']['range'] ?? "";
    $tier = $item['attributes']['raritytier'] ?? "1"; 
    $ammoType = $item['attributes']['ammotype'] ?? "";
    $containerSize = $item['attributes']['containersize'] ?? "";

    $color = ($tier >= 2 && $tier <= 4) ? ["#FF4D4D", "#E60000", "#990000"][$tier - 2] : "#FF9999";

    return "
        <tr class='rowPage $toggleClass'>
            <td><img src='$serverPath/items/". $item["attributes"]['clientid'] .".gif'></td>
            <td data-column='name'><a href='/about/itemPage/" . urlencode(strtolower($nameFormatted)) . "'><span>" . ucwords(strtolower($nameFormatted)) . "</span></a></td>
            <td>$ammoType</td>
            <td data-column='weight'>$weight oz</td>
            <td style='color: $color; text-shadow: 0px 0px 1px #000000;' data-column='tier'>$tier</td>
            <td data-column='armor'>$containerSize </td>
        </tr>";
}

function generateAmmunitionRow($item, $serverPath, $toggleClass, $nameFormatted){

    $weight = isset($item["attributes"]['weight']) ? number_format($item["attributes"]['weight'] / 100, 2) : "0.00";
    $ammoType = $item['attributes']['ammotype'] ?? "";
    $attack = $item['attributes']['attack'] ?? "0";

    return "
        <tr class='rowPage $toggleClass'>
            <td><img src='$serverPath/items/". $item["attributes"]['clientid'] .".gif'></td>
            <td data-column='name'><a href='/about/itemPage/" . urlencode(strtolower($nameFormatted)) . "'><span>" . ucwords(strtolower($nameFormatted)) . "</span></a></td>
            <td data-column='attack'>$attack</td>
            <td>$ammoType </td>
            <td data-column='weight'>$weight oz</td>
            <td></td>
        </tr>";

}

function generateAmuletsRow($item, $serverPath, $toggleClass, $nameFormatted){

    $weight = isset($item["attributes"]['weight']) ? number_format($item["attributes"]['weight'] / 100, 2) : "0.00";
    $armor = $item['attributes']['armor'] ?? "0";
    $attributeDetails = additionalNames::formatAttributes($item['attributes']);

    return "
        <tr class='rowPage $toggleClass'>
            <td><img src='$serverPath/items/". $item["attributes"]['clientid'] .".gif'></td>
            <td data-column='name'><a href='/about/itemPage/" . urlencode(strtolower($nameFormatted)) . "'><span>" . ucwords(strtolower($nameFormatted)) . "</span></a></td>
            <td data-column='weight'>$weight oz</td>
            <td data-column='tier'>$armor</td>
            <td>$attributeDetails</td>
        </tr>";

}

function generateRingsRow($item, $serverPath, $toggleClass, $nameFormatted){

    $weight = isset($item["attributes"]['weight']) ? number_format($item["attributes"]['weight'] / 100, 2) : "0.00";
    $attributeDetails = additionalNames::formatAttributes($item['attributes']);

    return "
        <tr class='rowPage $toggleClass'>
            <td><img src='$serverPath/items/". $item["attributes"]['clientid'] .".gif'></td>
            <td data-column='name'><a href='/about/itemPage/" . urlencode(strtolower($nameFormatted)) . "'><span>" . ucwords(strtolower($nameFormatted)) . "</span></a></td>
            <td data-column='weight'><span>$weight oz</span></td>
            <td>$attributeDetails</td>
        </tr>";

}


function generateRunesRow($item, $serverPath, $toggleClass, $nameFormatted){

    $runas = [

            "adana mort" => ["Animate Dead Rune", "Support"],
            "adana pox" => ["Cure Poison Rune", "Support"],
            "adevo mas vis" => ["Energy Bomb Rune", "Support"],
            "adori mas frigo" => ["Avalanche Rune", "Support"],
            "uteta res sac" => ["Avatar of Light", "Support"],
            "uteta res dru" => ["Avatar of Nature", "Support"],
            "uteta res eq" => ["Avatar of Steel", "Support"],
            "uteta res ven" => ["Avatar of Storm", "Support"],
            "exori" => ["Berserk", "Attack"],
            "utito tempo" => ["Blood Rage", "Support"],
            "exura infir ico" => ["Bruise Bane", "Healing"],
            "exori ico" => ["Brutal Strike", "Attack"],
            "exori infir vis" => ["Buzz", "Attack"],
            "exana ina" => ["Cancel Invisibility", "Support"],
            "exana vita" => ["Cancel Magic Shield", "Support"],
            "exeta res" => ["Challenge", "Support"],
            "adevo ina" => ["Chameleon Rune", "Support"],
            "utani tempo hur" => ["Charge", "Support"],
            "exevo infir frigo hur" => ["Chill Out", "Attack"],
            "exeta amp res" => ["Chivalrous Challenge", "Support"],
            "exevo con" => ["Conjure Arrow", "Support"],
            "exevo con flam" => ["Conjure Explosive Arrow", "Support"],
            "exevo gran mort" => ["Conjure Wand of Darkness", "Support"],
            "adeta sio" => ["Convince Creature Rune", "Support"],
            "utevo res ina" => ["Creature Illusion", "Support"],
            "exana kor" => ["Cure Bleeding", "Healing"],
            "exana flam" => ["Cure Burning", "Healing"],
            "exana mort" => ["Cure Curse", "Healing"],
            "exana vis" => ["Cure Electrification", "Healing"],
            "exana pox" => ["Cure Poison", "Healing"],
            "adana pox" => ["Cure Poison Rune", "Support"],
            "utori mort" => ["Curse", "Attack"],
            "exori mort" => ["Death Strike", "Attack"],
            "adito grav" => ["Destroy Field Rune", "Support"],
            "adito tera" => ["Disintegrate Rune", "Support"],
            "exevo mas san" => ["Divine Caldera", "Attack"],
            "exana amp res" => ["Divine Dazzle", "Support"],
            "utevo grav san" => ["Divine Empowerment", "Support"],
            "exevo tempo mas san" => ["Divine Grenade", "Attack"],
            "exura san" => ["Divine Healing", "Healing"],
            "exori san" => ["Divine Missile", "Attack"],
            "utori vis" => ["Electrify", "Attack"],
            "utori mas sio" => ["Enchant Party", "Support"],
            "exeta con" => ["Enchant Spear", "Support"],
            "exevo vis lux" => ["Energy Beam", "Attack"],
            "adevo mas vis" => ["Energy Bomb Rune", "Support"],
            "adevo grav vis" => ["Energy Field Rune", "Support"],
            "exori vis" => ["Energy Strike", "Attack"],
            "adevo mas grav vis" => ["Energy Wall Rune", "Support"],
            "exevo vis hur" => ["Energy Wave", "Attack"],
            "utori pox" => ["Envenom", "Attack"],
            "exevo gran mas frigo" => ["Eternal Winter", "Attack"],
            "exori con" => ["Ethereal Spear", "Attack"],
            "exori amp kor" => ["Executioner's Throw", "Attack"],
            "adevo mas hur" => ["Explosion Rune", "Support"],
            "exori moe" => ["Expose Weakness", "Support"],
            "exura med ico" => ["Fair Wound Cleansing", "Healing"],
            "exori gran" => ["Fierce Berserk", "Attack"],
            "exiva moe res" => ["Find Fiend", "Support"],
            "exiva" => ["Find Person", "Support"],
            "adevo mas flam" => ["Fire Bomb Rune", "Support"],
            "adevo grav flam" => ["Fire Field Rune", "Support"],
            "adevo mas grav flam" => ["Fire Wall Rune", "Support"],
            "exevo flam hur" => ["Fire Wave", "Attack"],
            "adori flam" => ["Fireball Rune", "Attack"],
            "exori flam" => ["Flame Strike", "Attack"],
            "exevo pan" => ["Food", "Support"],
            "exori min" => ["Front Sweep", "Attack"],
            "exevo max mort" => ["Great Death Beam", "Attack"],
            "exevo gran vis lux" => ["Great Energy Beam", "Attack"],
            "exevo gran flam hur" => ["Great Fire Wave", "Attack"],
            "adori gran" => ["Heavy Magic Missile Rune", "Support"],
            "exevo gran" => ["Great Fire", "Attack"],
            "utevo gran lux" => ["Great Light", "Support"],
            "exori mas" => ["Groundshaker", "Attack"],
            "utani hur" => ["Haste", "Support"],
            "exura sio" => ["Heal Friend", "Healing"],
            "utura mas sio" => ["Heal Party", "Support"],
            "adori vis" => ["Heavy Magic Missile Rune", "Support"],
            "exevo gran mas flam" => ["Hell's Core", "Attack"],
            "utori san" => ["Holy Flash", "Attack"],
            "adori san" => ["Holy Missile Rune", "Support"],
            "exevo ulus frigo" => ["Ice Burst", "Attack"],
            "exori frigo" => ["Ice Strike", "Attack"],
            "exevo frigo hur" => ["Ice Wave", "Attack"],
            "adori" => ["Light Magic Missile Rune", "Support"],
            "utori flam" => ["Ignite", "Attack"],
            "utori kor" => ["Inflict Wound", "Attack"],
            "exura gran" => ["Intense Healing", "Healing"],
            "adura gran" => ["Intense Healing Rune", "Healing"],
            "utura gran" => ["Intense Recovery", "Healing"],
            "exura gran ico" => ["Intense Wound Cleansing", "Healing"],
            "utana vid" => ["Invisible", "Support"],
            "exori infir con" => ["Lesser Ethereal Spear", "Attack"],
            "exori infir min" => ["Lesser Front Sweep", "Attack"],
            "exani hur" => ["Levitate", "Support"],
            "utevo lux" => ["Light", "Support"],
            "exura" => ["Light Healing", "Healing"],
            "adori min vis" => ["Light Magic Missile Rune", "Support"],
            "exori amp vis" => ["Lightning", "Attack"],
            "exura infir" => ["Magic Patch", "Healing"],
            "exani tera" => ["Magic Rope", "Support"],
            "utamo vita" => ["Magic Shield", "Support"],
            "adevo grav tera" => ["Magic Wall Rune", "Support"],
            "exura gran mas res" => ["Mass Healing", "Healing"],
            "exevo ulus tera" => ["Mud Attack", "Attack"],
            "exura gran sio" => ["Nature's Embrace", "Healing"],
            "adana ani" => ["Paralyse Rune", "Support"],
            "exori moe ico" => ["Physical Strike", "Attack"],
            "adevo res pox" => ["Envenom Rune", "Support"],
            "adevo grav pox" => ["Poison Field Rune", "Support"],
            "adevo mas grav pox" => ["Poison Wall Rune", "Support"],
            "adevo mas pox" => ["Poison Bomb Rune ", "Support"],
            "utamo mas sio" => ["Protect Party", "Support"],
            "utamo tempo" => ["Protector", "Support"],
            "exevo gran mas vis" => ["Rage of the Skies", "Attack"],
            "utura" => ["Recovery", "Healing"],
            "exura max vita" => ["Restoration", "Healing"],
            "exura gran san" => ["Salvation", "Healing"],
            "exori kor" => ["Sap Strength", "Support"],
            "exevo infir flam hur" => ["Scorch", "Attack"],
            "utito tempo san" => ["Sharpshooter", "Support"],
            "adevo res flam" => ["Soulfire Rune", "Support"],
            "adori tera" => ["Stalagmite Rune", "Support"],
            "exura si" => ["Support Healing", "Healing"],
            "adana sio" => ["Support Rune", "Support"],
            "adori vita vis" => ["Sudden Death Rune", "Attack"],
            "adevo grav vita" => ["Wild Growth Rune", "Attack"],
            "adura vita" => ["Ultimate Healing Rune", "Healing"],
            "adori gran flam" => ["Great Fireball Rune", "Attack"]

    ];

    $runasRetronia = [
        "adana mort" => ["name" => "Animate Dead Rune", "mlvl" => 2],
        "adana pox" => ["name" => "Antidote Rune", "mlvl" => 0],
        "adori gran frigo" => ["name" => "Avalanche Rune", "mlvl" => 5],
        "" => ["name" => "Blank Rune", "mlvl" => 0],
        "adevo ina" => ["name" => "Chameleon Rune", "mlvl" => 4],
        "adeta sio" => ["name" => "Convince Creature Rune", "mlvl" => 5],
        "adito tera" => ["name" => "Desintegrate Rune", "mlvl" => 4],
        "adito grav" => ["name" => "Destroy Field Rune", "mlvl" => 3],
        "adevo mas vis" => ["name" => "Energy Bomb Rune", "mlvl" => 10],
        "adevo grav vis" => ["name" => "Energy Field Rune", "mlvl" => 3],
        "adevo mas grav vis" => ["name" => "Energy Wall Rune", "mlvl" => 9],
        "adevo res pox" => ["name" => "Envenom Rune", "mlvl" => 4],
        "adevo mas hur" => ["name" => "Explosion Rune", "mlvl" => 6],
        "adevo grav flam" => ["name" => "Fire Field Rune", "mlvl" => 1],
        "adevo mas grav flam" => ["name" => "Fire Wall Rune", "mlvl" => 6],
        "adori flam" => ["name" => "Fireball Rune", "mlvl" => 2],
        "adevo mas flam" => ["name" => "Firebomb Rune", "mlvl" => 5],
        "adori gran flam" => ["name" => "Great Fireball Rune", "mlvl" => 4],
        "adori gran" => ["name" => "Heavy Magic Missile Rune", "mlvl" => 3],
        "adori frigo" => ["name" => "Icicle Rune", "mlvl" => 4],
        "adura gran" => ["name" => "Intense Healing Rune", "mlvl" => 1],
        "adori" => ["name" => "Light Magic Missile Rune", "mlvl" => 0],
        "adevo grav tera" => ["name" => "Magic Wall Rune", "mlvl" => 9],
        "adana ani" => ["name" => "Paralyze Rune", "mlvl" => 18],
        "adevo mas pox" => ["name" => "Poison Bomb Rune", "mlvl" => 4],
        "adevo grav pox" => ["name" => "Poison Field Rune", "mlvl" => 1],
        "adevo mas grav pox" => ["name" => "Poison Wall Rune", "mlvl" => 5],
        "adevo res flam" => ["name" => "Soulfire Rune", "mlvl" => 7],
        "adori vita vis" => ["name" => "Sudden Death Rune", "mlvl" => 15],
        "adura vita" => ["name" => "Ultimate Healing Rune", "mlvl" => 4],
    ];
    
    $spellName = "";
    $weight = isset($item["attributes"]['weight']) ? number_format($item["attributes"]['weight'] / 100, 2) : "0.00";
    $spellName = $item["attributes"]['runespellname'];

    $found = false;

    foreach ($runas as $key => $value) {

        if ($key === $spellName) {
            $found = true;
            break; 
        }
    }

    if($found){

        $runeName = $runasRetronia[$spellName]["name"];
        $runeGroup = $runas[$spellName][1];
        $magicLevel = $runasRetronia[$spellName]["mlvl"];

    }else{

        $runeName = "Spell Rune";
        $runeGroup = "Support";
        $magicLevel= "1";
    }

    $imageSrc = file_exists('items/' . $item["attributes"]['clientid'] . '.gif') 
                ? $item["attributes"]['clientid'] . '.gif' 
                : $item['id'] . '.gif';

    $imageType = file_exists('items/' . $item["attributes"]['clientid'] . '.gif') ? 'image' : 'reward';

    $itemName = $imageType === 'reward' ? $runeName . ' <small>(Daily Reward)</small>' : $runeName;

    return "
    <tr class='rowPage $toggleClass'>
        <td><img src='$serverPath/items/$imageSrc'></td>
        <td><a href='/about/itemPage/" . urlencode($runeName) . "'><span>$itemName</span></a></td>
        <td>" . $runeGroup . "</td>
        <td data-column='armor'>$magicLevel</td>
        <td data-column='name'><a href='/about/spellView/" . urlencode($spellName) . "'><span>$spellName</a></td>
        <td>$weight oz</td>
    </tr>";

}

function generateFoodsRow($item, $serverPath, $toggleClass, $nameFormatted){

    $foods = [
        2676 => ['name' => 'banana', 'value' => 8],
        2677 => ['name' => 'blueberry', 'value' => 1],
        2689 => ['name' => 'bread', 'value' => 10],
        2691 => ['name' => 'brown bread', 'value' => 8],
        2362 => ['name' => 'the carrot of doom', 'value' => 8],
        2684 => ['name' => 'carrot', 'value' => 8],
        2696 => ['name' => 'cheese', 'value' => 9],
        2679 => ['name' => 'cherry', 'value' => 1],
        2678 => ['name' => 'coconut', 'value' => 18],
        2687 => ['name' => 'cookie', 'value' => 2],
        2686 => ['name' => 'corncob', 'value' => 9],
        2792 => ['name' => 'dark mushroom', 'value' => 6],
        2672 => ['name' => 'dragon ham', 'value' => 60],
        2695 => ['name' => 'egg', 'value' => 6],
        2667 => ['name' => 'fish', 'value' => 12],
        5109 => ['name' => 'frozen ham', 'value' => 90],
        2681 => ['name' => 'grapes', 'value' => 9],
        2671 => ['name' => 'ham', 'value' => 30],
        2666 => ['name' => 'meat', 'value' => 15],
        2682 => ['name' => 'melon', 'value' => 20],
        2669 => ['name' => 'northern pike', 'value' => 17],
        2675 => ['name' => 'orange', 'value' => 13],
        2790 => ['name' => 'orange mushroom', 'value' => 30],
        2673 => ['name' => 'pear', 'value' => 5],
        2683 => ['name' => 'pumpkin', 'value' => 17],
        2674 => ['name' => 'red apple', 'value' => 6],
        2788 => ['name' => 'red mushroom', 'value' => 4],
        2690 => ['name' => 'roll', 'value' => 3],
        2668 => ['name' => 'salmon', 'value' => 10],
        2670 => ['name' => 'shrimp', 'value' => 4],
        2793 => ['name' => 'some mushrooms', 'value' => 12],
        2794 => ['name' => 'some mushrooms', 'value' => 3],
        2685 => ['name' => 'tomato', 'value' => 6],
        2787 => ['name' => 'white mushroom', 'value' => 9],
        2791 => ['name' => 'wood mushroom', 'value' => 9]
    ];

    $itemDescription = isset($item["attributes"]['description']) ? $item["attributes"]['description'] : "";

    $valueDisplay = ""; 

    if (isset($item['name'])) {
        $itemName = $item['name'];
        $found = false;

        foreach ($foods as $food) {
            if ($food['name'] === $itemName) {
                $found = true;
                if (isset($food['value'])) {
                    $valueDisplay = strval($food['value'] * 12) . " seconds"; 
                }
                break; 
            }
        }

        if (!$found) {
            $valueDisplay = "N/A"; 
        }
    }

    $weight = isset($item["attributes"]['weight']) ? number_format($item["attributes"]['weight'] / 100, 2) : "0.00";

    return "
        <tr class='rowPage $toggleClass'>
            <td><img src='$serverPath/items/". $item["attributes"]['clientid'] .".gif'></td>
            <td data-column='name'><a href='/about/itemPage/" . urlencode(strtolower($nameFormatted)) . "'><span>" . ucwords(strtolower($nameFormatted)) . "</span></a></td>
            <td data-column='regeneration'><span>$valueDisplay</span></td>
            <td><span>$itemDescription</span></td>
            <td data-column='weight'><span>$weight oz</span></td>
        </tr>";

}

function generateUtilsRow($item, $serverPath, $toggleClass, $nameFormatted){

    $itemDescription = isset($item["attributes"]['description']) ? $item["attributes"]['description'] : "";
    $weight = isset($item["attributes"]['weight']) ? number_format($item["attributes"]['weight'] / 100, 2) : "0.00";

    return "
        <tr class='rowPage $toggleClass'>
            <td><img src='$serverPath/items/". $item["attributes"]['clientid'] .".gif'></td>
            <td data-column='name'><a href='/about/itemPage/" . urlencode(strtolower($nameFormatted)) . "'><span>" . ucwords(strtolower($nameFormatted)) . "</span></a></td>
            <td><span>$itemDescription</span></td>
            <td data-column='weight'><span>$weight oz</span></td>
        </tr>";

}

function generateBagsRow($item, $serverPath, $toggleClass, $nameFormatted){

    $weight = isset($item["attributes"]['weight']) ? number_format($item["attributes"]['weight'] / 100, 2) : "0.00";
    $itemDescription = isset($item["attributes"]['description']) ? $item["attributes"]['description'] : "";
    $containerSize = isset($item["attributes"]['containersize']) ? $item["attributes"]['containersize'] : "0";
                            
    $imageSrc = file_exists('items/' . $item["attributes"]['clientid'] . '.gif')
        ? '/items/' . $item["attributes"]['clientid'] . '.gif'
        : '<span style="font-size: 32px; line-height: 32px;">❓</span>'; 

    return "
    <tr class='rowPage $toggleClass'>
        <td>
            " . (strpos($imageSrc, '❓') === false ? "<img src='$imageSrc' alt='Item Image'>" : $imageSrc) . "
        </td>
        <td data-column='name'>
            <a href='/about/itemPage/" . urlencode(strtolower($nameFormatted)) . "'>
                <span>" . ucwords(strtolower($nameFormatted)) . "</span>
            </a>
        </td>
        <td data-column='armor'>$containerSize</td>
        <td>$itemDescription</td>
        <td data-column='weight'>$weight</td>
    </tr>";
}

