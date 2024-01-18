<?php

namespace App\Services\Contracts;

use App\Http\Requests\Common\ListBySearchAndPaginationRequest;
use App\Http\Requests\Common\ListBySearchRequest;
use App\Http\Requests\Common\ListRequest;
use App\Http\Requests\Master\CreateCarRequest;
use App\Http\Requests\Master\ListCarBySearchAndPaginationRequest;
use App\Http\Requests\Master\ListCarBySearchRequest;
use App\Http\Requests\Master\ListCarRequest;
use App\Http\Requests\Master\UpdateCarRequest;
use App\Http\Responses\Common\BaseResponse;
use App\Http\Responses\Common\GenericListBySearchAndPaginationResponse;
use App\Http\Responses\Common\GenericListBySearchResponse;
use App\Http\Responses\Common\GenericListResponse;
use App\Http\Responses\Common\GenericObjectResponse;

interface ICarService
{
    public function fetchAllCars(ListCarRequest $request): GenericListResponse;

    public function fetchAllCarsBySearch(ListCarBySearchRequest $request): GenericListBySearchResponse;

    public function fetchAllCarsBySearchAndPagination(ListCarBySearchAndPaginationRequest $request): GenericListBySearchAndPaginationResponse;

    public function fetchCar(int $id): GenericObjectResponse;

    public function storeCar(CreateCarRequest $request): GenericObjectResponse;

    public function updateCar(int $id, UpdateCarRequest $request): GenericObjectResponse;

    public function destroyCar(int $id): BaseResponse;
}
