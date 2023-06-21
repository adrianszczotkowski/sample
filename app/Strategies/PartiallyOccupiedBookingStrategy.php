<?php

namespace App\Strategies;

use App\Commons\ConstantsPool as P;
use App\Commons\Database\ConstantsPool as D;
use App\Exceptions\BookingException;
use App\Models\Booking;
use App\Models\BookingItem;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

final readonly class PartiallyOccupiedBookingStrategy extends BookingStrategy
{
    /**
     * @throws BookingException
     */
    public function checkVacancies(): void
    {
        $this->checkDates();

        CarbonPeriod
            ::create($this->data[P::FROM], $this->data[P::TO])
            ->forEach($this->checkDate(...));
    }

    /**
     * @throws BookingException
     */
    private function checkDate(Carbon $day): void
    {
        $beds = BookingItem::find($this->data[D::BOOKING_ITEM_ID])->bed_count;

        Booking
            ::where(D::BOOKING_ITEM_ID, $this->data[D::BOOKING_ITEM_ID])
            ->where(D::BOOKING_DAY, $day)
            ->count() < $beds
            ?: throw new BookingException(BookingException::ALL_BEDS);
    }
}
