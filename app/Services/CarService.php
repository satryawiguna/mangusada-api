<?php

namespace App\Services;

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
use App\Repositories\Contracts\ICarRepository;
use App\Services\Contracts\ICarService;
use App\Enums\HttpResponseType;
use App\Http\Requests\Common\ListBySearchAndPaginationRequest;
use App\Http\Requests\Common\ListBySearchRequest;
use App\Http\Requests\Common\ListRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class CarService extends BaseService implements ICarService
{
    private readonly ICarRepository $_carRepository;

    public function __construct(ICarRepository $carRepository)
    {
        $this->_carRepository = $carRepository;
    }

    public function fetchAllCars(ListCarRequest $request): GenericListResponse
    {
        $response = new GenericListResponse();

        try {
            $positions = $this->_carRepository->all($request->order_by, $request->sort);

            $this->setGenericListResponse($response,
                $positions,
                'SUCCESS',
                HttpResponseType::SUCCESS->value);
        } catch (QueryException $ex) {
            $this->setMessageResponse($response,
                'Invalid query',
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

    public function fetchAllCarsBySearch(ListCarBySearchRequest $request): GenericListBySearchResponse
    {
        $response = new GenericListBySearchResponse();

        try {
            $cars = $this->_carRepository->allCarsBySearch($request);

            $this->setGenericListBySearchResponse($response,
                $cars,
                'SUCCESS',
                HttpResponseType::SUCCESS->value,
                $cars->count());
        } catch (QueryException $ex) {
            $this->setMessageResponse($response,
                'Invalid query',
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

    public function fetchAllCarsBySearchAndPagination(ListCarBySearchAndPaginationRequest $request): GenericListBySearchAndPaginationResponse
    {
        $response = new GenericListBySearchAndPaginationResponse();

        try {
            $cars = $this->_carRepository->allCarsBySearchAndPagination($request);

            $this->setGenericListBySearchAndPaginationResponse($response,
                $cars->getCollection(),
                'SUCCESS',
                HttpResponseType::SUCCESS->value,
                $cars->total(),
                ["per_page" => $cars->perPage(), "current_page" => $cars->currentPage()]);
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

    public function fetchCar(int $id): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $car = $this->_carRepository->findById($id);

            if (!$car) {
                throw new ModelNotFoundException("Car by id: {' .  $id . '} was not found on " . __FUNCTION__ . "()");
            }

            $this->setGenericObjectResponse($response,
                $car,
                'SUCCESS',
                HttpResponseType::SUCCESS->value);
        } catch (QueryException $ex) {
            $this->setMessageResponse($response,
                'Invalid query',
                'ERROR',
                HttpResponseType::BAD_REQUEST->value);
        } catch (ModelNotFoundException $ex) {
            $this->setMessageResponse($response,
                'Invalid object not found',
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

    public function storeCar(CreateCarRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            DB::beginTransaction();

            $createCar = $this->_carRepository->create($request);

            DB::commit();

            $this->setGenericObjectResponse($response,
                $createCar,
                'SUCCESS',
                HttpResponseType::SUCCESS->value);
        } catch (QueryException $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                'Invalid query',
                'ERROR',
                HttpResponseType::BAD_REQUEST->value);
        } catch (BadRequestException $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                'Bad request',
                'ERROR',
                HttpResponseType::BAD_REQUEST->value);

        } catch (Exception $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                'ERROR',
                HttpResponseType::INTERNAL_SERVER_ERROR->value,
                'Something went wrong');
        }

        return $response;
    }

    public function updateCar(int $id, UpdateCarRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        DB::beginTransaction();

        try {
            if ($id != $request->id) {
                throw new BadRequestException('Path parameter id: {' . $id . '} was not match with the request');
            }

            $car = $this->_carRepository->findById($id);

            if (!$car) {
                throw new ModelNotFoundException('Car by id: {' . $id . '} was not found on ' . __FUNCTION__ . '()');
            }

            $updateCar = $this->_carRepository->update($request);

            DB::commit();

            $this->setGenericObjectResponse($response,
                $updateCar,
                'SUCCESS',
                HttpResponseType::SUCCESS->value);
        } catch(QueryException $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                'Invalid query',
                'ERROR',
                HttpResponseType::BAD_REQUEST->value);
        } catch (ModelNotFoundException $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                'Invalid object not found',
                'ERROR',
                HttpResponseType::NOT_FOUND->value);
        } catch (BadRequestException $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                'Bad request',
                'ERROR',
                HttpResponseType::NOT_FOUND->value);
        } catch (Exception $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                'Something went wrong',
                'ERROR',
                HttpResponseType::INTERNAL_SERVER_ERROR->value);
        }

        return $response;
    }

    public function destroyCar(int $id): BaseResponse
    {
        $response = new BaseResponse();

        try {
            $car = $this->_carRepository->findById($id);

            if (!$car) {
                throw new ModelNotFoundException('Car by id: {' . $id . '} was not found on ' . __FUNCTION__ . '()');
            }

            $this->_carRepository->delete($id);

            $this->setMessageResponse($response,
                'Delete position by id: {' . $id . '} was succeed',
                "SUCCESS",
                HttpResponseType::SUCCESS->value);
        } catch (ModelNotFoundException $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                'Invalid object not found',
                'ERROR',
                HttpResponseType::NOT_FOUND->value);
        } catch(QueryException $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                'Invalid query',
                'ERROR',
                HttpResponseType::BAD_REQUEST->value);
        } catch (BadRequestException $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                'Bad request',
                'ERROR',
                HttpResponseType::NOT_FOUND->value);
        } catch (\Exception $ex) {
            $this->setMessageResponse($response,
                $ex->getMessage(),
                'ERROR',
                HttpResponseType::INTERNAL_SERVER_ERROR->value);
        }

        return $response;
    }

}
