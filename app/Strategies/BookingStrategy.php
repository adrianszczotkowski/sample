<?php

namespace App\Strategies;

use App\Commons\ConstantsPool as P;
use App\Exceptions\BookingException;
use App\Strategies\Contracts\BookingStrategyContract;
use Carbon\Carbon;

abstract readonly class BookingStrategy implements BookingStrategyContract
{
    public function __construct(public array $data)
    {
    }

    /**
     * @throws BookingException
     */
    public function checkDates(): void
    {
        Carbon
            ::parse($this->data[P::TO])
            ->greaterThanOrEqualTo(Carbon::parse($this->data[P::FROM]))
            ?: throw new BookingException('Invalid period provided');

        Carbon
            ::now()
            ->greaterThanOrEqualTo(Carbon::parse($this->data[P::FROM]))
            ?: throw new BookingException('Invalid start date provided');
    }
}
