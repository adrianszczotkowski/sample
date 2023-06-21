<?php

namespace Database\Seeders;

use App\Commons\Database\ConstantsPool as D;
use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function __construct(
        private readonly array $bookings = [
            [
                D::USER_ID => 1,
                D::BOOKING_ITEM_ID => 2,
            ],
        ]
    )
    {
    }

    public function run(): void
    {
        collect($this->bookings)
            ->map(fn($bookings) => [
                D::CREATED_AT => now(),
                D::BOOKING_DAY => now(),
                ...$bookings
            ])
            ->each(Booking::insertOrIgnore(...));
    }
}
