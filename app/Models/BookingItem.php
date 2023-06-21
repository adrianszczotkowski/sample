<?php

namespace App\Models;

use App\Commons\ConstantsPool as P;
use App\Commons\Database\ConstantsPool as D;
use App\Enums\TableNames as T;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\BookingItem
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string $name
 * @property int $bed_count
 * @property int $area
 * @property int $price
 * @property string $currency
 * @property-read Collection<int, Booking> $bookings
 * @property-read int|null $bookings_count
 * @method static Builder|BookingItem newModelQuery()
 * @method static Builder|BookingItem newQuery()
 * @method static Builder|BookingItem onlyTrashed()
 * @method static Builder|BookingItem query()
 * @method static Builder|BookingItem whereArea($value)
 * @method static Builder|BookingItem whereBedCount($value)
 * @method static Builder|BookingItem whereCreatedAt($value)
 * @method static Builder|BookingItem whereCurrency($value)
 * @method static Builder|BookingItem whereDeletedAt($value)
 * @method static Builder|BookingItem whereId($value)
 * @method static Builder|BookingItem whereName($value)
 * @method static Builder|BookingItem wherePrice($value)
 * @method static Builder|BookingItem whereUpdatedAt($value)
 * @method static Builder|BookingItem withTrashed()
 * @method static Builder|BookingItem withoutTrashed()
 * @method static where(string $key, string $value)
 * @method static create(array $data)
 * @method static find(mixed $id)
 * @method static self firstWhere(string $BOOKING_ITEM_ID, mixed $BOOKING_ITEM_ID1)
 */
class BookingItem extends Model
{
    use SoftDeletes;

    protected $table = T::booking_items->name;

    protected $fillable = [
        D::CREATED_AT,
        D::UPDATED_AT,
        D::DELETED_AT,
        D::NAME,
        D::BED_COUNT,
        D::AREA,
        D::PRICE,
        D::CURRENCY,
    ];

    protected $casts = [
        D::CREATED_AT => P::DATETIME,
        D::UPDATED_AT => P::DATETIME,
        D::DELETED_AT => P::DATETIME,
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, D::BOOKING_ITEM_ID);
    }

    protected function translatedName(): Attribute
    {
        return Attribute::make(
            get: static fn(?string $value, array $attributes) => __($attributes[D::NAME]),
        );
    }
}
