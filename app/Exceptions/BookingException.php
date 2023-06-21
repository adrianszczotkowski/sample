<?php

namespace App\Exceptions;

use Exception;

class BookingException extends Exception
{
    public const
        ALL_BEDS = 'All beds already booked within the specified period',
        SOME_BEDS = 'Some beds already booked within the specified period';
}
