<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\House
 *
 * @property int $id
 * @property string $owner
 * @property int $paid
 * @property int $warnings
 * @property string $name
 * @property int $rent
 * @property int $town_id
 * @property int $bid
 * @property int $bid_end
 * @property int $last_bid
 * @property int $highest_bidder
 * @property int $size
 * @property int $beds
 * @method static Builder|House newModelQuery()
 * @method static Builder|House newQuery()
 * @method static Builder|House query()
 * @method static Builder|House whereId($value)
 * @method static Builder|House whereOwner($value)
 * @method static Builder|House wherePaid($value)
 * @method static Builder|House whereWarnings($value)
 * @method static Builder|House whereName($value)
 * @method static Builder|House whereRent($value)
 * @method static Builder|House whereTownId($value)
 * @method static Builder|House whereBid($value)
 * @method static Builder|House whereBidEnd($value)
 * @method static Builder|House whereLastBid($value)
 * @method static Builder|House whereHighestBidder($value)
 * @method static Builder|House whereSize($value)
 * @method static Builder|House whereBeds($value)
 * @mixin \Eloquent
 */

class House extends Model
{
    public $timestamps = false;

    /** @var string[] */
    protected $fillable = [
        'id',
        'owner',
        'paid',
        'warnings',
        'name',
        'rent',
        'town_id',
        'bid',
        'bid_end',
        'last_bid',
        'highest_bidder',
        'size',
        'beds',
    ];

    public function ownerPlayer(): hasOne
    {
        return $this->hasOne(Player::class, 'id', 'owner');
    }

    public function details(): hasOne
    {
        return $this->hasOne(WebHouses::class, 'house_id', 'id');
    }

    public function highestBidderPlayer(): hasOne
    {
        return $this->hasOne(Player::class, 'id', 'highest_bidder');
    }

    public function moveOut(): hasOne
    {
        return $this->hasOne(WebHouseMoveOut::class, 'house_id', 'id');
    }

    public function ownerOnLoggedInAccount(): bool
    {
        if (Auth::check() && !is_null($this->ownerPlayer) && $this->ownerPlayer->account_id === Auth::user()->id) {
            return true;
        }
        return false;
    }

    public function moveOutOnGoing(): bool
    {
        return !is_null($this->moveOut);
    }

    public function getRentAttribute(): int
    {
        return config('houses.rentPricePerSqm') * $this->attributes['size'];
    }
}
