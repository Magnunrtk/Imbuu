<?php

declare(strict_types=1);

namespace App\Enum;

class ProcessingTime
{
    const VERY_FAST = 1;
    const MEDIUM = 2;
    const SLOW = 3;
    const VARIES = 4;

    public static function getString(int $value): string
    {
        return match ($value) {
            self::VERY_FAST => 'very fast',
            self::MEDIUM => 'medium',
            self::SLOW => 'slow',
            self::VARIES => 'varies',
            default => 'Unknown',
        };
    }

    public static function getStringFromString(string $value): string
    {
        dd($value);
        return self::getString((int) $value);
    }

    public static function getTimeEstimation(int $value): string
    {
        return match ($value) {
            self::VERY_FAST => 'several minutes',
            self::MEDIUM => 'around half an hour',
            self::SLOW => 'several hours',
            self::VARIES => 'varies',
            default => 'Unknown',
        };
    }
}