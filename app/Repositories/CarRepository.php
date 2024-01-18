<?php

namespace App\Repositories;

use App\Http\Requests\Common\ListRequest;
use App\Http\Requests\Master\ListCarBySearchAndPaginationRequest;
use App\Http\Requests\Master\ListCarBySearchRequest;
use App\Http\Requests\Master\ListCarRequest;
use App\Models\BaseModel;
use App\Models\Car;
use App\Repositories\Contracts\ICarRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CarRepository extends BaseRepository implements ICarRepository
{
    public function __construct(Car $car)
    {
        parent::__construct($car);
    }

    public function all(ListRequest|ListCarRequest $request): Collection
    {
        $car = $this->_model;

        if ($request->start_date && $request->end_date) {
            $car = $this->searchCarByStartDateAndEndDate($car, $request->start_date, $request->end_date);
        }

        return $car->orderBy($request->order_by, $request->sort)
            ->get();
    }

    private function searchCarByStartDateAndEndDate(BaseModel|Builder $car, string $startDate, string $endDate)
    {
        return $car->whereHas('reservations', function ($query) use ($startDate, $endDate) {
            $query->where(function ($query) use ($startDate, $endDate) {
                $query->whereNull('checkin_date')
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->where('checkout_start_date', '<=', $startDate)
                            ->where('checkout_end_date', '>=', $startDate)
                            ->orWhere('checkout_start_date', '<=', $endDate)
                            ->where('checkout_end_date', '>=', $endDate);
                    })
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->whereNotNull('checkin_date')
                            ->where(function ($query) use ($startDate, $endDate) {
                                $query->where('checkout_start_date', '<=', $startDate)
                                    ->where('checkin_date', '>=', $startDate)
                                    ->orWhere('checkout_start_date', '<=', $endDate)
                                    ->where('checkin_date', '>=', $endDate);
                            });
                    });
            });
        });
    }

    public function allCarsBySearch(ListCarBySearchRequest $request): Collection
    {
        $car = $this->_model;

        if ($request->search) {
            $keyword = $request->search;

            $car = $car->whereRaw("(brand LIKE ? OR model LIKE ? OR year = ? OR license_plate LIKE ?)", $this->searchCarByKeyword($keyword));
        }

        if ($request->start_date && $request->end_date) {
            $car = $this->searchCarByStartDateAndEndDate($car, $request->start_date, $request->end_date);
        }

        return $car->orderBy($request->order_by, $request->sort)
            ->get();
    }

    private function searchCarByKeyword(string $keyword)
    {
        return [
            'brand' => "%" . $keyword . "%",
            'model' => "%" . $keyword . "%",
            'year' => $keyword,
            'license_plate' => "%" . $keyword . "%"
        ];
    }

    public function allCarsBySearchAndPagination(ListCarBySearchAndPaginationRequest $request): LengthAwarePaginator
    {
        $car = $this->_model;

        if ($request->search) {
            $keyword = $request->search;

            $car = $car->whereRaw("(brand LIKE ? OR model LIKE ? OR year = ? OR license_plate LIKE ?)", $this->searchCarByKeyword($keyword));
        }

        if ($request->start_date && $request->end_date) {
            $car = $this->searchCarByStartDateAndEndDate($car, $request->start_date, $request->end_date);
        }

        return $car->orderBy($request->order_by, $request->sort)
            ->paginate($request->per_page, ['*'], 'page', $request->page);
    }

    public function findById(int|string $id,
                             ?string    $startDate = null,
                             ?string    $endDate = null): BaseModel|null
    {
        $car = $this->_model;

        if ($startDate && $endDate) {
            $car = $this->searchCarByStartDateAndEndDate($car, $startDate, $endDate);
        }

        return $car->where('id', $id)->first();
    }
}
