<?php

namespace Tests\Feature;

use App\Commons\ConstantsPool as P;
use App\Commons\Database\ConstantsPool as D;
use App\Exceptions\BookingException;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Services\BookingService;
use App\Services\Contracts\BookingServiceContract;
use App\Strategies\EmptyOnlyBookingStrategy;
use App\Strategies\PartiallyOccupiedBookingStrategy;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Throwable;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private BookingServiceContract $bookingService;

    public function test_booking_should_be_added(): void
    {
        //given
        $date = now();
        $data = [
            D::USER_ID => 1,
            D::BOOKING_ITEM_ID => 1,
            P::FROM => $date,
            P::TO => $date
        ];
        $strategy = new EmptyOnlyBookingStrategy($data);

        //when
        $bookings = $this
            ->bookingService
            ->validate($strategy)
            ->process();

        //then
        $bookingDate = Carbon::parse($bookings->first()->booking_day);
        self::assertNotEmpty($bookings);
        self::assertEquals($date->year, $bookingDate->year);
        self::assertEquals($date->day, $bookingDate->day);
    }

    public function test_should_throw_exception_when_adding_booking_more_than_once(): void
    {
        //given
        $date = now()->toDateString();
        $data = [
            D::USER_ID => 1,
            D::BOOKING_ITEM_ID => 1,
            P::FROM => $date,
            P::TO => $date
        ];
        $strategy = new EmptyOnlyBookingStrategy($data);
        $this
            ->bookingService
            ->validate($strategy)
            ->process();

        try {
            //when
            $this
                ->bookingService
                ->validate($strategy)
                ->process();
        } catch (Throwable $exception) {
            //then
            static::assertEquals(BookingException::SOME_BEDS, $exception->getMessage());

            return;
        }

        static::fail();
    }

    public function test_booking_should_be_added_until_beds_lasts(): void
    {
        //given
        $date = now()->toDateString();
        $data = [
            D::USER_ID => 1,
            D::BOOKING_ITEM_ID => 1,
            P::FROM => $date,
            P::TO => $date
        ];
        $strategy = new PartiallyOccupiedBookingStrategy($data);
        $beds = $bedCount = BookingItem
            ::find($data[D::BOOKING_ITEM_ID])
            ->bed_count;

        //when
        while ($beds) {
            $beds--;
            $this
                ->bookingService
                ->validate($strategy)
                ->process();
        }

        $bedsOccupied = Booking
            ::where(D::BOOKING_ITEM_ID, $data[D::BOOKING_ITEM_ID])
            ->count();

        //then
        self::assertEquals(0, $beds);
        self::assertEquals($bedsOccupied, $bedCount);
    }

    public function test_should_throw_exception_when_the_bed_limit_is_exceeded(): void
    {
        //given
        $date = now()->toDateString();
        $data = [
            D::USER_ID => 1,
            D::BOOKING_ITEM_ID => 1,
            P::FROM => $date,
            P::TO => $date
        ];
        $strategy = new PartiallyOccupiedBookingStrategy($data);
        $beds = BookingItem
            ::find($data[D::BOOKING_ITEM_ID])
            ->bed_count;

        while ($beds) {
            $beds--;
            $this
                ->bookingService
                ->validate($strategy)
                ->process();
        }

        try {
            //when
            $this
                ->bookingService
                ->validate($strategy)
                ->process();
        } catch (Throwable $exception) {
            //then
            static::assertEquals(BookingException::ALL_BEDS, $exception->getMessage());

            return;
        }

        static::fail();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookingService = app(BookingService::class);
    }
}
