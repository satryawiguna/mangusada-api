<?php

use App\Http\Controllers\Api\v1\Master\CarController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => '/car'], function () {
        Route::group(['prefix' => '/list'], function () {
            Route::get('/', [CarController::class, 'list'])->name('api.car.list');
            Route::get('/search', [CarController::class, 'listBySearch'])->name('api.car.list.search');
            Route::get('/search/page', [CarController::class, 'listBySearchAndPage'])->name('api.car.list.search.page');
        });
        Route::get('/{id}', [CarController::class, 'show'])->name('api.car.show');
        Route::post('/', [CarController::class, 'store'])->name('api.car.create');
        Route::put('/{id}', [CarController::class, 'update'])->name('api.car.update');
        Route::delete('/{id}', [CarController::class, 'destroy'])->name('api.car.destroy');
    });
});
