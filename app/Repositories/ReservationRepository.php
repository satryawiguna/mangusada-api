<?php

namespace App\Repositories;

use App\Http\Requests\Reservation\ListReservationBySearchAndPaginationRequest;
use App\Models\Reservation;
use App\Repositories\Contracts\IReservationRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReservationRepository extends BaseRepository implements IReservationRepository
{
    public function __construct(Reservation $reservation)
    {
        parent::__construct($reservation);
    }

    public function allReservationsBySearchAndPagination(ListReservationBySearchAndPaginationRequest $request): LengthAwarePaginator
    {
        $reservation = $this->_model;

        if ($request->car_id) {
            $carId = $request->car_id;

            $reservation = $reservation->where("car_id", $carId);
        }

        if ($request->user_id) {
            $userId = $request->user_id;

            $reservation = $reservation->where("user_id", $userId);
        }

        if ($request->start_date && $request->end_date) {
            $reservation = $reservation->whereBetween('checkout_start_date', [$request->start_date, $request->end_date]);
        }

        return $reservation->orderBy($request->order_by, $request->sort)
            ->paginate($request->per_page, ['*'], 'page', $request->page);
    }
}
