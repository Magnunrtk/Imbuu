<?php

declare(strict_types=1);

namespace App\Http\Requests\Guilds;

use App\Utils\GuildRanks;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class GuildManagementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            Redirect::back()->with(
                'error',
                preg_replace('/\s+/', ' ', $validator->errors()->first())
            )
        );
    }

    public function rules(Request $request): array
    {
        $input = $this->all();
        $basename = basename($this->getPathInfo());
        $this->guild = $request->guild;
        $input['name'] = $this->guild->name;
        switch ($basename) {
            case 'member':
                if (!is_null($input['action'])) {
                    if (!in_array((int) $input['action'], [1,2,3])) {
                        $input['action'] = 0;
                    }
                    $rules = $this->memberRulesByAction((int) $input['action']);
                }
                break;
            default:
                break;
        }
        $this->replace($input);

        return match ($basename) {
            //Create new guild
            'create' => [
                'guildName' => 'bail|required|unique:guilds,name',
                'character' => 'bail|required|character_exists|character_on_account|has_no_guild',
                'password' => 'bail|required|string|current_password',
            ],
            //Update rank amount
            'rank' => [
                'ranks' => 'bail|required|integer|not_in: '. $request->guild->ranks->count() .'|min:'. GuildRanks::MIN_RANKS_AMOUNT .'|max:'. GuildRanks::MAX_RANKS_AMOUNT,
            ],
            //Update guild rank name
            'name' => [
                'newRankName' => 'bail|required|string|strictly_profane:de,en,' . config_path('custom_validation.php') . '|min:2|max:29',
                'guildName' => 'bail|guild_rank_level:'. GuildRanks::VICE_LEADER_LEVEL,
                'rank_id' => 'bail|required|integer',
            ],
            //Edit guild members
            'member' => $rules,
            //Leave guild
            'leave' => [
                'character' => 'bail|required|character_exists|character_on_account|has_guild',
                'name' => 'bail|required|guild_rank_level:'. GuildRanks::MEMBER_LEVEL,
            ],
            //Join guild
            'join' => [
                'name' => 'bail|required',
                'character' => 'bail|required|character_exists|character_on_account|has_no_guild',
            ],
            //Invite to guild
            //Accept/reject guild application
            'invite' => [
                'name' => 'bail|required|guild_rank_level:'. GuildRanks::VICE_LEADER_LEVEL,
                'character' => 'bail|required|character_exists|has_no_guild',
            ],
            //Cancel guild invitation
            'cancel' => [
                'name' => 'bail|required|guild_rank_level:'. GuildRanks::VICE_LEADER_LEVEL,
                'character' => 'bail|required|character_exists',
            ],
            //Disband guild
            'disband' => [
                'name' => 'bail|required|guild_rank_level:'. GuildRanks::LEADER_LEVEL,
                'password' => 'required|string|current_password',
            ],
            //Deny guild application
            'allow', 'deny' => [
                'name' => 'bail|required|guild_rank_level:'. GuildRanks::VICE_LEADER_LEVEL,
            ],
            'description' => [
                'name' => 'bail|required|guild_rank_level:'. GuildRanks::LEADER_LEVEL,
                'description' => 'string|max:500',
            ],
            'logo' => [
                'name' => 'bail|required|guild_rank_level:'. GuildRanks::LEADER_LEVEL,
                'logo' => 'max:64|mimes:gif|dimensions:max_width=64,max_height=64',
            ],
        };
    }

    public function messages(): array
    {
        $input = $this->all();
        $basename = basename($this->getPathInfo());
        switch ($basename) {
            case 'member':
                if (!is_null($input['action'])) {
                    $messages = $this->memberMessagesByAction((int) $input['action']);
                }
                break;
            default:
                break;
        }

        return match ($basename) {
            'create' => [
                'guildName.required' => 'Please enter a valid guild name.',
                'guildName.unique' => 'This guild name is already used. Please choose another name!',
                'character.required' => 'Character was not found.',
                'character.character_exists' => 'Character was not found.',
                'character.character_on_account' => 'This character does not belong to your account.',
                'character.has_no_guild' => 'This character is already a member of a guild.',
                'password.required' => 'The password is required.',
                'password.string' => 'The password format is invalid.',
                'password.current_password' => 'The password you have entered is not correct!',
            ],
            'rank' => [
                'ranks.required' => 'The number of ranks must be between 
            '. GuildRanks::MIN_RANKS_AMOUNT .' and '. GuildRanks::MAX_RANKS_AMOUNT.'.',
                'ranks.integer' => 'The number of ranks must be between 
            '. GuildRanks::MIN_RANKS_AMOUNT .' and '. GuildRanks::MAX_RANKS_AMOUNT.'.',
                'ranks.min' => 'The number of ranks must be between 
            '. GuildRanks::MIN_RANKS_AMOUNT .' and '. GuildRanks::MAX_RANKS_AMOUNT.'.',
                'ranks.max' => 'The number of ranks must be between 
            '. GuildRanks::MIN_RANKS_AMOUNT .' and '. GuildRanks::MAX_RANKS_AMOUNT.'.',
                'ranks.not_in' => 'The old number of ranks is similar to your entered number.'
            ],
            'name' => [
                'newRankName.required' => 'Please enter a rank name.',
                'newRankName.string' => 'The new rank name format is invalid.',
                'newRankName.min' => 'A name must have at least :min but no more than :max letters.',
                'newRankName.max' => 'The new rank name cannot have more than :max letters.',
                'newRankName.regex' => 'The new rank name can only contain letters and spaces.',
                'newRankName.strictly_profane' => 'The new rank name contains bad words.',
                'rank_id.required' => 'Invalid rank selection.',
                'rank_id.integer' => 'Invalid rank selection.',
                'guildName.guild_rank_level' => 'You have no right to edit rank names.',
            ],
            'member' => $messages,
            'leave' => [
                'name.required' => 'Guild was not found.',
                'name.guild_rank_level' => 'You are not a member of this guild.',
                'character.required' => 'Character was not found.',
                'character.character_exists' => 'Character was not found.',
                'character.character_on_account' => 'This character does not belong to your account.',
                'character.has_guild' => 'This character has no guild.',
            ],
            'join' => [
                'name.required' => 'Guild was not found.',
                'character.required' => 'Character was not found.',
                'character.character_exists' => 'Character was not found.',
                'character.character_on_account' => 'This character does not belong to your account.',
                'character.has_no_guild' => 'This character is already a member of a guild.',
            ],
            'invite' => [
                'name.required' => 'Guild was not found.',
                'name.guild_rank_level' => 'You have no right to invite characters.',
                'character.required' => 'Character was not found.',
                'character.character_exists' => 'Character was not found.',
                'character.character_on_account' => 'This character does not belong to your account.',
                'character.has_no_guild' => 'This character is already a member of a guild.',
            ],
            'cancel' => [
                'name.required' => 'Guild was not found.',
                'name.guild_rank_level' => 'You have no right to invite characters.',
                'character.required' => 'Character was not found.',
                'character.character_exists' => 'Character was not found.',
                'character.character_on_account' => 'This character does not belong to your account.',
            ],
            'disband' => [
                'name.required' => 'Guild was not found.',
                'name.guild_rank_level' => 'You are not the owner of this guild!',
                'password.required' => 'The password is required.',
                'password.string' => 'The password format is invalid.',
                'password.current_password' => 'The password you have entered is not correct!',
            ],
            'allow', 'deny' => [
                'name.required' => 'Guild was not found.',
                'name.guild_rank_level' => 'Only guild leader and vices an change guild application status!',
            ],
            'description' => [
                'name.required' => 'Guild was not found.',
                'name.guild_rank_level' => 'You are not the owner of this guild!',
                'description.string' => 'The guild description format is not correct.',
                'description.max' => 'The guild description is longer than :max characters.',
            ],
            'logo' => [
                'name.required' => 'Guild was not found.',
                'name.guild_rank_level' => 'You are not the owner of this guild!',
                'logo.mimes' => 'You may only use GIF images.',
                'logo.max' => 'The logo must not exceed 64 KBytes.',
                'logo.dimensions' => 'The logo must not exceed 64x64 pixels.',
                'logo.uploaded' => 'The logo must not exceed upload size limitation.',
            ],
        };
    }

    private function memberRulesByAction(int $action): array
    {
        return match ($action) {
            0, 1 => [
                'name' => 'bail|required|guild_rank_level:' . GuildRanks::VICE_LEADER_LEVEL,
                'action' => 'bail|required|in:0,1',
                'character' => 'bail|required|character_exists|has_guild',
                'rank_id' => 'bail|required|integer',
            ],
            2 => [
                'name' => 'bail|required|guild_rank_level:' . GuildRanks::LEADER_LEVEL,
                'action' => 'bail|required|in:2',
                'character' => 'bail|required|character_exists|has_guild',
            ],
            3 => [
                'name' => 'bail|required|guild_rank_level:' . GuildRanks::LEADER_LEVEL,
                'action' => 'bail|required|in:3',
                'character' => 'bail|required|character_exists|has_guild',
            ],
        };
    }

    private function memberMessagesByAction(int $action): array
    {
        return match ($action) {
            0, 1 => [
                'name.guild_rank_level' => 'You have no right to change the ranks.',
                'action.required' => 'Invalid action selected.',
                'action.in' => 'Please select an action.',
                'character.required' => 'Character was not found.',
                'character.character_exists' => 'Character was not found.',
                'character.has_guild' => 'This character has no guild.',
                'rank_id.required' => 'Invalid rank selection.',
                'rank_id.integer' => 'Invalid rank selection.',
            ],
            2 => [
                'name.required' => 'Guild was not found.',
                'name.guild_rank_level' => 'You may may not confer titles.',
                'action.required' => 'Invalid action selected.',
                'action.in' => 'Please select an action.',
                'character.required' => 'Character was not found.',
                'character.character_exists' => 'Character was not found.',
                'character.has_guild' => 'This character has no guild.',
            ],
            3 => [
                'name.required' => 'Guild was not found.',
                'name.guild_rank_level' => 'You may may not exclude members.',
                'action.required' => 'Invalid action selected.',
                'action.in' => 'Please select an action.',
                'character.required' => 'Character was not found.',
                'character.character_exists' => 'Character was not found.',
                'character.has_guild' => 'This character has no guild.',
            ],
        };
    }
}