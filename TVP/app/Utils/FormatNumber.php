<?php

declare(strict_types=1);

namespace App\Utils;


class FormatNumber
{
    public static function properConvert(int $value): string
    {
        return $value >= 1000 ? round($value / 1000, 0, PHP_ROUND_HALF_UP) . 'k' : (string) $value;
    }
}
