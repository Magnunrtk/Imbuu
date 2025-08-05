<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\WebPaymentOption
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $processing_time
 * @property string $additional_title
 * @property string $additional_text
 * @property int $active
 * @property mixed $created_at
 * @property Carbon $updated_at
 * @method static Builder|WebPaymentOption newModelQuery()
 * @method static Builder|WebPaymentOption newQuery()
 * @method static Builder|WebPaymentOption query()
 * @method static Builder|WebPaymentOption whereId($value)
 * @method static Builder|WebPaymentOption whereName($value)
 * @method static Builder|WebPaymentOption whereSlug($value)
 * @method static Builder|WebPaymentOption whereProcessingTime($value)
 * @method static Builder|WebPaymentOption whereAdditionalTitle($value)
 * @method static Builder|WebPaymentOption whereAdditionalText($value)
 * @method static Builder|WebPaymentOption whereActive($value)
 * @method static Builder|WebPaymentOption whereCreatedAt($value)
 * @method static Builder|WebPaymentOption whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class WebPaymentOption extends Model
{
    /** @var string[] */
    protected $fillable = [
        'id',
        'name',
        'slug',
        'processing_time',
        'additional_title',
        'additional_text',
        'active',
    ];

    /** @var string[] */
    protected $casts = [
        'active' => 'bool',
    ];
}
