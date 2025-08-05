<?php

declare(strict_types=1);

return [
    0 => [
        'name' => 'None',
    ],
    1 => [
        'name' => 'Sorcerer',
        'child_id' => [5],
    ],
    2 => [
        'name' => 'Druid',
        'child_id' => [6],
    ],
    3 => [
        'name' => 'Paladin',
        'child_id' => [7],
    ],
    4 => [
        'name' => 'Knight',
        'child_id' => [8],
    ],
    5 => [
        'parent_id' => [1],
        'name' => 'Master Sorcerer',
    ],
    6 => [
        'parent_id' => [2],
        'name' => 'Elder Druid',
    ],
    7 => [
        'parent_id' => [3],
        'name' => 'Royal Paladin',
    ],
    8 => [
        'parent_id' => [4],
        'name' => 'Elite Knight',
    ],
];
