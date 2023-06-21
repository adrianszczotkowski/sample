<?php

namespace App\Resolvers;

use App\Models\User;
use Money\Money;

class UserResolver
{
    public function payments(User $user): array
    {
        return Money
            ::PLN(
                $user
                    ->bookings()
                    ->with(['bookingItem'])
                    ->get()
                    ->map(fn($booking) => $booking->bookingItem->price)
                    ->sum()
            )
            ->jsonSerialize();
    }
}
