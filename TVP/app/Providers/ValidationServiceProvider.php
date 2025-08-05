<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Guild;
use App\Models\Player;
use App\Models\WebChangeEmail;
use App\Utils\GuildRanks;
use Illuminate\Support\Carbon;
use GuzzleHttp\Client;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ValidationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Validator::extend('world_slug_exists', function($attribute, $value, $parameters) {
            $value = Str::urlToStr($value);
            if(!in_array($value, array_column(config('multi_world.worlds'), 'slug'))) {
                return false;
            }
            return true;
        });
        Validator::extend('town_slug_exists', function($attribute, $value, $parameters) {
            $value = Str::urlToStr($value);
            if(!in_array($value, array_column(config('towns.town_ids'), 'slug'))) {
                return false;
            }
            return true;
        });
        Validator::extend('email_change_active', function($attribute, $value, $parameters) {
            if(WebChangeEmail::whereAccountId(Auth::user()->id)->whereConfirmed(false)->first()) {
                return false;
            }
            return true;
        });
        Validator::extend('max_characters', function($attribute, $value, $parameters) {
            if(Player::whereAccountId(Auth::user()->id)->count() > (int) $parameters[0]) {
                return false;
            }
            return true;
        });
        Validator::extend('guild_rank_level', function ($attribute, $value, $parameters, $validator) {
            $value = Str::urlToStr($value);
            $guild = Guild::whereName($value)->first();
            if(GuildRanks::getHighestRankLevel($guild) !== 0 &&
                GuildRanks::getHighestRankLevel($guild) <= (int) $parameters[0]) {
                return true;
            }
            return false;
        });
        Validator::extend('has_no_guild', function ($attribute, $value, $parameters, $validator) {
            $value = Str::urlToStr($value);
            $character = Player::whereName($value)->first();
            if(!is_null($character) && $character->guild_membership
                || !is_null($character) && $character->guild_owner) {
                return false;
            }
            return true;
        });
        Validator::extend('has_guild', function ($attribute, $value, $parameters, $validator) {
            $value = Str::urlToStr($value);
            $character = Player::whereName($value)->first();
            if(!is_null($character) && $character->guild_membership
                || !is_null($character) && $character->guild_owner) {
                return true;
            }
            return false;
        });
        Validator::extend('character_exists', function ($attribute, $value, $parameters, $validator) {
            $value = Str::urlToStr($value);
            return Player::whereName($value)->exists();
        });
        Validator::extend('character_on_account', function ($attribute, $value, $parameters, $validator) {
            $value = Str::urlToStr($value);
            $targetCharacter = Player::whereName($value)->first();
            if($targetCharacter->account_id === Auth::user()->id) {
                return true;
            }
            return false;
        });
        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator) {
            if(env('APP_ENV') !== 'production') {
                return true;
            }
            $client = new Client;
            $response = $client->post(
                'https://www.google.com/recaptcha/api/siteverify',
                [
                    'form_params' =>
                        [
                            'secret' => config('services.recaptcha.secret'),
                            'response' => $value
                        ]
                ]
            );
            $body = json_decode((string)$response->getBody());
            return $body->success;
        });
        Validator::extend('date_in_past', function ($attribute, $value, $parameters, $validator) {
            try {
                $date = Carbon::createFromFormat('d/m/Y', $value);
            } catch (\Exception $e) {
                return false;
            }
            return !$date->startOfDay()->isPast();
        });
    }
}
