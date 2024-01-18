<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Master\ListCarBySearchAndPaginationRequest;
use App\Http\Requests\Master\ListCarBySearchRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ICarRepository
{
    public function allCarsBySearch(ListCarBySearchRequest $request): Collection;

    public function allCarsBySearchAndPagination(ListCarBySearchAndPaginationRequest $request): LengthAwarePaginator;
}
