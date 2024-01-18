<?php

use App\Http\Controllers\Api\v1\ReservationController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => '/reservation'], function () {
        Route::group(['prefix' => '/list'], function () {
            Route::get('/search/page', [ReservationController::class, 'listBySearchAndPage'])->name('api.reservation.list.search.page');
        });
        Route::post('/checkout', [ReservationController::class, 'checkOut'])->name('api.reservation.checkout');
        Route::put('/checkin/{id}', [ReservationController::class, 'checkIn'])->name('api.reservation.checkin');
    });
});
