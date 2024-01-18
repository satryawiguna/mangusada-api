<?php

namespace App\Providers;

use App\Repositories\CarRepository;
use App\Repositories\Contracts\ICarRepository;
use App\Repositories\Contracts\IReservationRepository;
use App\Repositories\Contracts\IUserRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(ICarRepository::class, CarRepository::class);
        $this->app->bind(IReservationRepository::class, ReservationRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
