<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Support\Carbon;

class TimeAgoConvert
{
    public static function diff(Carbon $date, string $format = 'Y-m-d H:i'): string
    {
        $dateCopy = clone $date;
        $startCurrentWeek = Carbon::now()->startOfWeek()->format('Y-m-d H:i');
        $startOfWeekTargetDate = $dateCopy->startOfWeek()->format('Y-m-d H:i');
        if($date->diffInSeconds() < 30) {
            return 'a moment ago';
        }
        if($date->diffInSeconds() < 60) {
            return $date->diffInSeconds(). ' seconds ago';
        }
        if($date->diffInMinutes() < 60) {
            return $date->diffInMinutes() === 1 ? $date->diffInMinutes().' minute ago' : $date->diffInMinutes().' minutes ago';
        }
        if($date->diffInHours() < 24) {
            return 'Today at '. $date->format('h:i A');
        }
        if($date->diffInDays() === 1) {
            return 'Yesterday at '. $date->format('h:i A');
        }
        if($date->diffInHours() > 1 && $startOfWeekTargetDate === $startCurrentWeek) {
            return $date->format('l h:i A');
        }
        return $date->format('M d,Y');
    }
}
