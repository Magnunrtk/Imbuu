<?php

declare(strict_types=1);

namespace App\Http\Traits;

trait RecoveryKey {

    public function recoveryKeyGenerate(): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';

        for ($i = 0; $i < 20; $i++) {
            $string .= $characters[rand(0, strlen($characters) - 1)];

            if (($i + 1) % 5 === 0 && $i !== 19) {
                $string .= '-';
            }
        }
        return $string;
    }

    public function validateRecoveryKeyFormat($string): bool
    {
        $string = str_replace('-', '', $string);
        if (strlen($string) !== 20) {
            return false;
        }
        if (!ctype_alnum($string)) {
            return false;
        }
        return true;
    }
}