<?php

namespace App\Services\Contracts;

use App\Strategies\Contracts\BookingStrategyContract;
use Illuminate\Support\Collection;

interface BookingServiceContract
{
    public function process(): Collection;

    public function validate(BookingStrategyContract $strategy): self;

    public function checkPrice(array $data): array;

    public function simulatePrice(array $data): array;
}
