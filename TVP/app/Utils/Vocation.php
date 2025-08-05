<?php

declare(strict_types=1);

namespace App\Utils;

class Vocation
{
    public static function getNameByVocationId(int $vocationId): string
    {
        if(config('vocations')[$vocationId]) {
            return config('vocations')[$vocationId]['name'];
        }
        return 'Vocation not found';
    }
}
