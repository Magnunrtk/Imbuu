<?php

declare(strict_types=1);

namespace App\Http\Traits;
use Symfony\Component\Process\PhpExecutableFinder;

trait RunArtisanInBackground {

    public static function runInBackground(string $command): void
    {
        exec((new PhpExecutableFinder())->find() . ' ' . env('ARTISAN_PATH') . ' ' . $command . ' > /dev/null 2>&1 &');
    }
}