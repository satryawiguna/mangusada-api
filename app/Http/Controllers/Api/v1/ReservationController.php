<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Common\ListBySearchAndPaginationRequest;
use App\Http\Requests\Reservation\CheckInRequest;
use App\Http\Requests\Reservation\CheckOutRequest;
use App\Http\Requests\Reservation\ListReservationBySearchAndPaginationRequest;
use App\Http\Resources\Reservation\CheckInResource;
use App\Http\Resources\Reservation\CheckOutResource;
use App\Http\Resources\Reservation\ReservationCollectionResource;
use App\Services\Contracts\IReservationService;

class ReservationController extends ApiBaseController
{
    public IReservationService $_reservationService;

    public function __construct(IReservationService $reservationService)
    {
        $this->_reservationService = $reservationService;
    }

    public function listBySearchAndPage(ListReservationBySearchAndPaginationRequest $request)
    {
        $reservations = $this->_reservationService->fetchAllReservationsBySearchAndPagination($request);

        if ($reservations->isError()) {
            return $this->getErrorLatestJsonResponse($reservations);
        }

        return $this->getListBySearchAndPaginationJsonResponse($reservations, ReservationCollectionResource::class);
    }

    public function checkOut(CheckOutRequest $request)
    {
        $reservations = $this->_reservationService->checkOut($request);

        if ($reservations->isError()) {
            return $this->getErrorLatestJsonResponse($reservations);
        }

        return $this->getObjectJsonResponse($reservations, CheckOutResource::class);
    }

    public function checkIn(int $id, CheckInRequest $request)
    {
        $reservations = $this->_reservationService->checkIn($id, $request);

        if ($reservations->isError()) {
            return $this->getErrorLatestJsonResponse($reservations);
        }

        return $this->getObjectJsonResponse($reservations, CheckInResource::class);
    }
}
