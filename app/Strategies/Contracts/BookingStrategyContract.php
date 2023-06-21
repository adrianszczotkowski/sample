<?php

namespace App\Strategies\Contracts;

interface BookingStrategyContract
{
    public function checkVacancies(): void;

    public function checkDates(): void;
}
