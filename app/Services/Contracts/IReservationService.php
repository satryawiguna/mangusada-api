<?php

namespace App\Services\Contracts;

use App\Http\Requests\Common\ListBySearchAndPaginationRequest;
use App\Http\Requests\Reservation\CheckInRequest;
use App\Http\Requests\Reservation\CheckOutRequest;
use App\Http\Requests\Reservation\ListReservationBySearchAndPaginationRequest;
use App\Http\Responses\Common\GenericListBySearchAndPaginationResponse;
use App\Http\Responses\Common\GenericObjectResponse;

interface IReservationService
{
    public function fetchAllReservationsBySearchAndPagination(ListReservationBySearchAndPaginationRequest $request): GenericListBySearchAndPaginationResponse;

    public function checkOut(CheckOutRequest $request): GenericObjectResponse;

    public function checkIn(int $id, CheckInRequest $request): GenericObjectResponse;
}
