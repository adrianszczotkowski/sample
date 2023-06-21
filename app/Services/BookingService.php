<?php

namespace App\Services;

use App\Commons\ConstantsPool as P;
use App\Commons\Database\ConstantsPool as D;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Services\Contracts\BookingServiceContract;
use App\Strategies\Contracts\BookingStrategyContract;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Money\Money;

final class BookingService implements BookingServiceContract
{
    public function __construct(
        private readonly Collection $bookings,
        private Collection          $data)
    {
    }

    public function process(): Collection
    {
        CarbonPeriod
            ::create(
                $this->data->get(P::FROM),
                $this->data->get(P::TO)
            )
            ->forEach($this->create(...));

        return $this->bookings;
    }

    private function create(Carbon $day): void
    {
        $this->data->put(D::BOOKING_DAY, $day);
        $this
            ->bookings
            ->push(Booking::create($this->data->toArray()));
    }

    public function validate(BookingStrategyContract $strategy): self
    {
        $this->data = collect($strategy->data);

        $strategy->checkVacancies();

        return $this;
    }

    public function checkPrice(array $data): array
    {
        return Money
            ::PLN(
                Booking
                    ::where(D::USER_ID, $data[D::USER_ID])
                    ->whereBetween(
                        D::BOOKING_DAY,
                        [
                            $data[P::FROM],
                            $data[P::TO]
                        ])
                    ->with(['bookingItem'])
                    ->get()
                    ->map(fn($booking) => $booking->bookingItem->price)
                    ->sum()
            )
            ->jsonSerialize();
    }

    public function simulatePrice(array $data): array
    {
        $price = collect(
            CarbonPeriod
                ::create(
                    $data[P::FROM],
                    $data[P::TO]
                )
                ->map(fn(Carbon $day) => BookingItem
                    ::firstWhere(D::ID, $data[D::BOOKING_ITEM_ID])
                    ->price
                )
        )->sum();

        return Money
            ::PLN($price)
            ->jsonSerialize();
    }
}
