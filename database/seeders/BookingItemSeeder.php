<?php

namespace Database\Seeders;

use App\Commons\Database\ConstantsPool as D;
use App\Models\BookingItem;
use Illuminate\Database\Seeder;

class BookingItemSeeder extends Seeder
{
    public function __construct(
        private readonly array $bookingItems = [
            [
                D::NAME => 'Cabin',
                D::BED_COUNT => 2,
                D::AREA => 15,
                D::PRICE => 10000
            ],
            [
                D::NAME => 'Cottage',
                D::BED_COUNT => 4,
                D::AREA => 90,
                D::PRICE => 30000
            ],
            [
                D::NAME => 'Apartament',
                D::BED_COUNT => 4,
                D::AREA => 110,
                D::PRICE => 45000
            ],
            [
                D::NAME => 'House',
                D::BED_COUNT => 6,
                D::AREA => 220,
                D::PRICE => 70000
            ],
        ]
    )
    {
    }

    public function run(): void
    {
        collect($this->bookingItems)
            ->map(fn($bookingItem) => [
                D::CREATED_AT => now(),
                ...$bookingItem
            ])
            ->each(BookingItem::insertOrIgnore(...));
    }
}
