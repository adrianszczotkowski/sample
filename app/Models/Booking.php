<?php

namespace App\Models;

use App\Commons\ConstantsPool as P;
use App\Commons\Database\ConstantsPool as D;
use App\Enums\TableNames as T;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Booking
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property int $user_id
 * @property int $booking_item_id
 * @property Carbon $booking_day
 * @property-read BookingItem $bookingItem
 * @property-read User $user
 * @method static Builder|Booking newModelQuery()
 * @method static Builder|Booking newQuery()
 * @method static Builder|Booking onlyTrashed()
 * @method static Builder|Booking query()
 * @method static Builder|Booking whereBookingDay($value)
 * @method static Builder|Booking whereBookingItemId($value)
 * @method static Builder|Booking whereCreatedAt($value)
 * @method static Builder|Booking whereDeletedAt($value)
 * @method static Builder|Booking whereId($value)
 * @method static Builder|Booking whereUpdatedAt($value)
 * @method static Builder|Booking whereUserId($value)
 * @method static Builder|Booking withTrashed()
 * @method static Builder|Booking withoutTrashed()
 * @method static where(string $key, mixed $value)
 * @method static create(mixed[] $toArray)
 */
class Booking extends Model
{
    use SoftDeletes;

    protected $table = T::bookings->name;

    protected $fillable = [
        D::CREATED_AT,
        D::UPDATED_AT,
        D::DELETED_AT,
        D::USER_ID,
        D::BOOKING_ITEM_ID,
        D::BOOKING_DAY,
    ];

    protected $casts = [
        D::CREATED_AT => P::DATETIME,
        D::UPDATED_AT => P::DATETIME,
        D::DELETED_AT => P::DATETIME,
        D::BOOKING_DAY => P::DATE,
    ];

    public function bookingItem(): BelongsTo
    {
        return $this->belongsTo(BookingItem::class, D::BOOKING_ITEM_ID);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, D::USER_ID);
    }
}
