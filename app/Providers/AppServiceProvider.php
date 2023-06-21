<?php

namespace App\Providers;

use App\Services\BookingService;
use App\Services\Contracts\BookingServiceContract;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $this
            ->app
            ->bind(BookingServiceContract::class, BookingService::class);
    }
}
