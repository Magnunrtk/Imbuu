<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebNews
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int $type
 * @property int $category
 * @property int $player_id
 * @property int|null $last_modified_by
 * @property string|null $article_text
 * @property string|null $article_image
 * @property bool $hidden
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Player $author
 * @property Player|null $lastModifiedBy
 * @method static Builder|WebNews newModelQuery()
 * @method static Builder|WebNews newQuery()
 * @method static Builder|WebNews query()
 * @method static Builder|WebNews whereId($value)
 * @method static Builder|WebNews whereTitle($value)
 * @method static Builder|WebNews whereBody($value)
 * @method static Builder|WebNews whereType($value)
 * @method static Builder|WebNews whereCategory($value)
 * @method static Builder|WebNews wherePlayerId($value)
 * @method static Builder|WebNews whereLastModifiedBy($value)
 * @method static Builder|WebNews whereArticleText($value)
 * @method static Builder|WebNews whereArticleImage($value)
 * @method static Builder|WebNews whereHidden($value)
 * @method static Builder|WebNews whereCreatedAt($value)
 * @method static Builder|WebNews whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebNews extends Model
{
    protected $table = 'web_news';

    protected $fillable = [
        'id',
        'title',
        'body',
        'type',
        'category',
        'player_id',
        'last_modified_by',
        'article_text',
        'article_image',
        'hidden',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public function lastModifiedBy(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'last_modified_by', 'id');
    }
}