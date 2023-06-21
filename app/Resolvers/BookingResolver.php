<?php

namespace App\Resolvers;

use App\Commons\ConstantsPool as P;
use App\Resolvers\Traits\HandlesData;
use App\Services\Contracts\BookingServiceContract;
use App\Strategies\EmptyOnlyBookingStrategy;
use App\Strategies\PartiallyOccupiedBookingStrategy;
use Illuminate\Support\Collection;

readonly class BookingResolver
{
    use HandlesData;

    public function __construct(private BookingServiceContract $bookingService)
    {
    }

    public function __invoke(?array $root, array $args): Collection
    {
        $data = $this->merge($root, $args);

        $strategy = $data[P::EMPTY_ONLY]
            ? new EmptyOnlyBookingStrategy($data)
            : new PartiallyOccupiedBookingStrategy($data);

        return $this
            ->bookingService
            ->validate($strategy)
            ->process();
    }

    public function price(?array $root, array $args): array
    {
        $data = $this->merge($root, $args);

        return $data[P::SIMULATE_PRICE]
            ? $this->bookingService->simulatePrice($data)
            : $this->bookingService->checkPrice($data);
    }
}
