<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private array $seeders = [
        BookingItemSeeder::class,
        BookingSeeder::class,
    ];

    public function run(): void
    {
        User
            ::factory(2)
            ->create();

        $this->call($this->seeders);
    }
}
