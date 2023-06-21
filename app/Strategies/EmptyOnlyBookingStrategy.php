<?php

namespace App\Strategies;

use App\Commons\ConstantsPool as P;
use App\Commons\Database\ConstantsPool as D;
use App\Exceptions\BookingException;
use App\Models\Booking;

final readonly class EmptyOnlyBookingStrategy extends BookingStrategy
{
    /**
     * @throws BookingException
     */
    public function checkVacancies(): void
    {
        $this->checkDates();

        !Booking
            ::where(D::BOOKING_ITEM_ID, $this->data[D::BOOKING_ITEM_ID])
            ->whereBetween(D::BOOKING_DAY, [
                $this->data[P::FROM],
                $this->data[P::TO]
            ])
            ->count()
            ?: throw new BookingException(BookingException::SOME_BEDS);
    }
}
