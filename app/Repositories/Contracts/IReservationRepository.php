<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Common\ListBySearchAndPaginationRequest;
use App\Http\Requests\Reservation\ListReservationBySearchAndPaginationRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IReservationRepository
{
    public function allReservationsBySearchAndPagination(ListReservationBySearchAndPaginationRequest $request): LengthAwarePaginator;
}
