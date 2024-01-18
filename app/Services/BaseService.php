<?php

namespace App\Services;

use App\Services\Contracts\IBaseService;
use App\Http\Responses\Common\BaseResponse;
use App\Http\Responses\Common\BooleanResponse;
use App\Http\Responses\Common\GenericListBySearchAndPaginationResponse;
use App\Http\Responses\Common\GenericListBySearchResponse;
use App\Http\Responses\Common\GenericListResponse;
use App\Http\Responses\Common\GenericObjectResponse;
use App\Http\Responses\Common\IntegerResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseService implements IBaseService
{
    public function setMessageResponse(BaseResponse $response,
                                       string|array $message = null,
                                       string $type,
                                       int $codeStatus)
    {
        $response->type = $type;
        $response->codeStatus = $codeStatus;

        if (is_array($message)) {
            foreach ($message as $key => $value) {
                foreach ($value as $item) {
                    $method = "add" . ucfirst($type) . "MessageResponse";
                    $response->$method($item);
                }
            }
        } else {
            $method = "add" . ucfirst($type) . "MessageResponse";

            $response->$method($message);
        }

        return $response;
    }

    public function setIntegerResponse(IntegerResponse $response,
                                       int $result,
                                       string $type,
                                       int $codeStatus): IntegerResponse
    {
        $response->result = $result;

        $this->setBaseResponse($response, $type, $codeStatus);

        return $response;
    }

    public function setBooleanResponse(BooleanResponse $response,
                                       bool $result,
                                       string $type,
                                       int $codeStatus): BooleanResponse
    {
        $response->result = $result;

        $this->setBaseResponse($response, $type, $codeStatus);

        return $response;
    }


    public function setGenericObjectResponse(GenericObjectResponse $response,
                                             Model|array|null $dto,
                                             string $type,
                                             int $codeStatus): GenericObjectResponse
    {
        $response->dto = $dto;

        $this->setBaseResponse($response, $type, $codeStatus);

        return $response;
    }

    public function setGenericListResponse(GenericListResponse $response,
                                           Collection $dtoList,
                                           string $type,
                                           int $codeStatus): GenericListResponse
    {
        $response->dtoList = $dtoList;

        $this->setBaseResponse($response, $type, $codeStatus);

        return $response;
    }

    public function setGenericListBySearchResponse(GenericListBySearchResponse $response,
                                                   Collection $dtoListBySearch,
                                                   string $type,
                                                   int $codeStatus,
                                                   int $totalCount): GenericListBySearchResponse
    {
        $response->dtoListBySearch = $dtoListBySearch;

        $this->setBaseResponse($response, $type, $codeStatus);

        $response->totalCount = $totalCount;

        return $response;
    }

    public function setGenericListBySearchAndPaginationResponse(GenericListBySearchAndPaginationResponse $response,
                                                                Collection $dtoListBySearchAndPagination,
                                                                string $type,
                                                                int $codeStatus,
                                                                int $totalCount,
                                                                array $meta): GenericListBySearchAndPaginationResponse
    {
        $response->dtoListBySearchAndPagination = $dtoListBySearchAndPagination;

        $this->setBaseResponse($response, $type, $codeStatus);

        $response->totalCount = $totalCount;
        $response->meta = $meta;

        return $response;
    }

    private function setBaseResponse($response, $type, $codeStatus): void
    {
        $response->type = $type;
        $response->codeStatus = $codeStatus;
    }
}
