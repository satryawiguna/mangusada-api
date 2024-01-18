<?php

namespace App\Providers;

use App\Services\CarService;
use App\Services\Contracts\ICarService;
use App\Services\Contracts\IReservationService;
use App\Services\Contracts\IUserService;
use App\Services\ReservationService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserService::class, UserService::class);
        $this->app->bind(ICarService::class, CarService::class);
        $this->app->bind(IReservationService::class, ReservationService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
