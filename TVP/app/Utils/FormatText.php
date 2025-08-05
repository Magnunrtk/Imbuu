<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Support\Str;

class FormatText
{
    public static function checkTextFormat(string $name, string $useCase): string
    {
        if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
            return sprintf('This %s contains invalid letters. Please use only A-Z, a-z and space.', $useCase);
        }
        if($name[0] == ' ') {
            return sprintf('This %s contains a space at the beginning. Please remove this space.', $useCase);
        }
        if(!self::firstLetterCapital(array_values(self::wordCount($name))[0])) {
            return sprintf('The first letter of a %s has to be a capital letter.', $useCase);
        }
        if($name[strlen($name)-1] === ' ') {
            return sprintf('This %s contains a space at the end. Please remove this space.', $useCase);
        }

        if(preg_match_all('/[ ]/', $name) >= count(self::wordCount($name))) {
            return sprintf(
                'This %s contains more than one space between words. Please use only one space between words.',
                $useCase
            );
        }
        if(count(self::wordCount($name)) > 5) {
            return sprintf('This %s contains more than 5 words. Please choose another %s.', $useCase, $useCase);
        }
        $i = 1;
        foreach (self::wordCount($name) as $word) {
            if(in_array(strtolower($word), config('custom_validation'))) {
                return sprintf(
                    'This %s cannot be used because it contains a forbidden word or combination of letters. Please choose another %s!',
                    $useCase,
                    $useCase
                );
            }
            if(self::countVowel($word) === 0) {
                return sprintf(
                    'This %s contains a word without vowels. Please choose another %s.',
                    $useCase,
                    $useCase
                );
            }
            if(strlen($word) === 1) {
                return sprintf(
                    'This %s contains a word with only one letter. Please use more than one letter for each word.',
                    $useCase
                );
            }
            if(strlen($word) > 14) {
                return sprintf(
                    'This %s contains a word that is too long. Please use no more than 14 letters for each word.',
                    $useCase
                );
            }
            if (preg_match("([a-z0-9]*[A-Z]\w*)", substr($word, 1))) {
                return 'In names capital letters are only allowed at the beginning of a word.';
            }
            $i++;
        }
        if(strlen($name) < 2 || strlen($name) > 29) {
            return sprintf('A %s must have at least 2 but no more than 29 letters.', $useCase);
        }
        return '';
    }

    private static function wordCount(string $name): array|int
    {
        return str_word_count($name, 1);
    }

    private static function firstLetterCapital(string $name): bool
    {
        if(substr($name, 0, 1) === strtoupper(substr($name, 0, 1))) {
            return true;
        }
        return false;
    }

    private static function countVowel(string $name): int
    {
        $checkName = Str::lower($name);
        return substr_count($checkName, 'a') + substr_count($checkName, 'e') +
            substr_count($checkName, 'i') + substr_count($checkName, 'o') +
            substr_count($checkName, 'u') + substr_count($checkName, 'y');
    }
}
