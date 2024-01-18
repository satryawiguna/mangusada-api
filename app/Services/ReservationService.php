<?php

namespace App\Services;

use App\Enums\HttpResponseType;
use App\Http\Requests\Reservation\CheckInRequest;
use App\Http\Requests\Reservation\CheckOutRequest;
use App\Http\Requests\Reservation\ListReservationBySearchAndPaginationRequest;
use App\Http\Responses\Common\GenericListBySearchAndPaginationResponse;
use App\Http\Responses\Common\GenericObjectResponse;
use App\Repositories\Contracts\ICarRepository;
use App\Repositories\Contracts\IReservationRepository;
use App\Services\Contracts\IReservationService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ReservationService extends BaseService implements IReservationService
{
    private readonly IReservationRepository $_reservationRepository;
    private readonly ICarRepository $_carRepository;

    public function __construct(IReservationRepository $reservationRepository,
                                ICarRepository         $carRepository)
    {
        $this->_reservationRepository = $reservationRepository;
        $this->_carRepository = $carRepository;
    }

    public function fetchAllReservationsBySearchAndPagination(ListReservationBySearchAndPaginationRequest $request): GenericListBySearchAndPaginationResponse
    {
        $response = new GenericListBySearchAndPaginationResponse();

        try {
            $reservations = $this->_reservationRepository->allReservationsBySearchAndPagination($request);

            $this->setGenericListBySearchAndPaginationResponse($response,
                $reservations->getCollection(),
                'SUCCESS',
                HttpResponseType::SUCCESS->value,
                $reservations->total(),
                ["per_page" => $reservations->perPage(), "current_page" => $reservations->currentPage()]);
        } catch (QueryException $ex) {
            $this->setMessageResponse($response,
                $ex->getMessage(),
                'ERROR',
                HttpResponseType::BAD_REQUEST->value);
        } catch (Exception $ex) {
            $this->setMessageResponse($response,
                'Something went wrong',
                'ERROR',
                HttpResponseType::INTERNAL_SERVER_ERROR->value);
        }

        return $response;
    }

    public function checkOut(CheckOutRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        DB::beginTransaction();

        try {
            $car = $this->_carRepository->findById($request->car_id, $request->checkout_start_date, $request->checkout_end_date);

            if ($car) {
                throw new ModelNotFoundException('Car by id: {' . $request->car_id . '} was not found on ' . __FUNCTION__ . '()');
            }

            $checkOut = $this->_reservationRepository->create($request);

            DB::commit();

            $this->setGenericObjectResponse($response,
                $checkOut,
                'SUCCESS',
                HttpResponseType::SUCCESS->value);
        } catch (QueryException $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                $ex->getMessage(),
                'ERROR',
                HttpResponseType::BAD_REQUEST->value);
        } catch (ModelNotFoundException $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                $ex->getMessage(),
                'ERROR',
                HttpResponseType::BAD_REQUEST->value);
        } catch (Exception $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                'Something went wrong',
                'ERROR',
                HttpResponseType::INTERNAL_SERVER_ERROR->value);
        }

        return $response;
    }

    public function checkIn(int $id, CheckInRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        DB::beginTransaction();

        try {
            if ($id != $request->id) {
                throw new BadRequestException('Path parameter id: {' . $id . '} was not match with the request');
            }

            $reservation = $this->_reservationRepository->findById($request->id);

            if (!$reservation)
                throw new ModelNotFoundException('Reservation not found');

            $checkinDate = Carbon::parse($request->checkin_date);
            $checkoutDate = Carbon::parse($reservation->checkout_start_date);
            $totalDurationInDays = $checkinDate->diffInDays($checkoutDate);

            $request->merge([
                "total_duration" => $totalDurationInDays,
                "total_cost" => $totalDurationInDays * $reservation->car->rental_rate
            ]);

            $checkIn = $this->_reservationRepository->update($request);

            DB::commit();

            $this->setGenericObjectResponse($response,
                $checkIn,
                'SUCCESS',
                HttpResponseType::SUCCESS->value);
        } catch (QueryException $ex) {
            $this->setMessageResponse($response,
                'Invalid query',
                'ERROR',
                HttpResponseType::BAD_REQUEST->value);
        } catch (ModelNotFoundException $ex) {
            $this->setMessageResponse($response,
                $ex->getMessage(),
                'ERROR',
                HttpResponseType::BAD_REQUEST->value);
        } catch (Exception $ex) {
            $this->setMessageResponse($response,
                'Something went wrong',
                'ERROR',
                HttpResponseType::INTERNAL_SERVER_ERROR->value);
        }

        return $response;
    }

}
