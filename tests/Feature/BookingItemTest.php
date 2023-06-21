<?php

namespace Tests\Feature;

use App\Commons\Database\ConstantsPool as D;
use App\Models\BookingItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingItemTest extends TestCase
{
    use RefreshDatabase;

    private const
        SOME_NAME = 'some item name',
        OTHER_NAME = 'other item name';

    public function test_booking_item_should_be_added_and_updated(): void
    {
        //given
        $querySomeName = BookingItem::where(D::NAME, self::SOME_NAME);
        $queryOtherName = BookingItem::where(D::NAME, self::OTHER_NAME);
        $bookingItemBefore = $querySomeName->first();

        //when
        BookingItem
            ::create([
                D::NAME => self::SOME_NAME,
                D::BED_COUNT => 10,
                D::AREA => 10,
                D::PRICE => 100
            ]);

        $bookingItem = $querySomeName->first();

        $querySomeName
            ->first()
            ->setAttribute(D::NAME, self::OTHER_NAME)
            ->save();

        $bookingItemAfterUpdate = $queryOtherName->first();

        //then
        self::assertNull($bookingItemBefore);
        self::assertNotNull($bookingItem);
        self::assertEquals(self::SOME_NAME, $bookingItem->name);
        self::assertEquals(self::OTHER_NAME, $bookingItemAfterUpdate->name);
    }
}
