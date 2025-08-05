<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebGuild
 *
 * @property int $id
 * @property int $guild_id
 * @property string $logo_name
 * @property string|null $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebGuild newModelQuery()
 * @method static Builder|WebGuild newQuery()
 * @method static Builder|WebGuild query()
 * @method static Builder|WebGuild whereId($value)
 * @method static Builder|WebGuild whereGuildId($value)
 * @method static Builder|WebGuild whereLogoName($value)
 * @method static Builder|WebGuild whereDescription($value)
 * @method static Builder|WebGuild whereCreatedAt($value)
 * @method static Builder|WebGuild whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebGuild extends Model
{
    protected $fillable = [
        'id',
        'guild_id',
        'logo_name',
        'description',
    ];

    public function guild()
    {
        return $this->belongsTo(Guild::class, 'guild_id', 'id');
    }
}