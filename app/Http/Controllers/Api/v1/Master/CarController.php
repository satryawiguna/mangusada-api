<?php

namespace App\Http\Controllers\Api\v1\Master;

use App\Http\Controllers\Api\v1\ApiBaseController;
use App\Http\Requests\Master\CreateCarRequest;
use App\Http\Requests\Master\ListCarBySearchAndPaginationRequest;
use App\Http\Requests\Master\ListCarBySearchRequest;
use App\Http\Requests\Master\ListCarRequest;
use App\Http\Requests\Master\UpdateCarRequest;
use App\Http\Resources\Car\CarCollectionResource;
use App\Http\Resources\Car\CarResource;
use App\Services\Contracts\ICarService;

class CarController extends ApiBaseController
{
    public ICarService $_carService;

    public function __construct(ICarService $carService)
    {
        $this->_carService = $carService;
    }

    public function list(ListCarRequest $request)
    {
        $cars = $this->_carService->fetchAllCars($request);

        if ($cars->isError()) {
            return $this->getErrorLatestJsonResponse($cars);
        }

        return $this->getListJsonResponse($cars, CarCollectionResource::class);
    }

    public function listBySearch(ListCarBySearchRequest $request)
    {
        $cars = $this->_carService->fetchAllCarsBySearch($request);

        if ($cars->isError()) {
            return $this->getErrorLatestJsonResponse($cars);
        }

        return $this->getListBySearchJsonResponse($cars, CarCollectionResource::class);
    }

    public function listBySearchAndPage(ListCarBySearchAndPaginationRequest $request)
    {
        $cars = $this->_carService->fetchAllCarsBySearchAndPagination($request);

        if ($cars->isError()) {
            return $this->getErrorLatestJsonResponse($cars);
        }

        return $this->getListBySearchAndPaginationJsonResponse($cars, CarCollectionResource::class);
    }

    public function show(int $id)
    {
        $car = $this->_carService->fetchCar($id);

        if ($car->isError()) {
            return $this->getErrorLatestJsonResponse($car);
        }

        return $this->getObjectJsonResponse($car, CarResource::class);
    }

    public function store(CreateCarRequest $request)
    {
        $storeCar = $this->_carService->storeCar($request);

        if ($storeCar->isError()) {
            return $this->getErrorLatestJsonResponse($storeCar);
        }

        return $this->getObjectJsonResponse($storeCar, CarResource::class);
    }

    public function update(int $id, UpdateCarRequest $request)
    {
        $updateCar = $this->_carService->updateCar($id, $request);

        if ($updateCar->isError()) {
            return $this->getErrorLatestJsonResponse($updateCar);
        }

        return $this->getObjectJsonResponse($updateCar, CarResource::class);
    }

    public function destroy(int $id)
    {
        $destroyCar = $this->_carService->destroyCar($id);

        if ($destroyCar->isError()) {
            return $this->getErrorLatestJsonResponse($destroyCar);
        }

        return $this->getSuccessLatestJsonResponse($destroyCar);
    }
}
