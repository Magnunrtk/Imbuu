<?php

declare(strict_types=1);

namespace App\Utils;

class NewsType
{
    public const NEWS = 1;
    public const TICKER = 2;
    public const ARTICLE = 3;

    public static function getName(int $val): string
    {
        return match ($val) {
            self::NEWS => 'News',
            self::TICKER => 'Ticker',
            self::ARTICLE => 'Article',
        };
    }
}