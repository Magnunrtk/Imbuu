<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebBlacklistEntry
 *
 * @property int $id
 * @property string $email
 * @property string $ip
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebBlacklistEntry newModelQuery()
 * @method static Builder|WebBlacklistEntry newQuery()
 * @method static Builder|WebBlacklistEntry query()
 * @method static Builder|WebBlacklistEntry whereId($value)
 * @method static Builder|WebBlacklistEntry whereEmail($value)
 * @method static Builder|WebBlacklistEntry whereIp($value)
 * @method static Builder|WebBlacklistEntry whereCreatedAt($value)
 * @method static Builder|WebBlacklistEntry whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebBlacklistEntry extends Model
{
    protected $table = 'web_blacklist_entries';

    /** @var string[] */
    protected $fillable = [
        'id',
        'email',
        'ip',
    ];
}
