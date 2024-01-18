<?php

namespace App\Services\Contracts;

use App\Http\Responses\Common\BaseResponse;
use App\Http\Responses\Common\BooleanResponse;
use App\Http\Responses\Common\GenericListBySearchAndPaginationResponse;
use App\Http\Responses\Common\GenericListBySearchResponse;
use App\Http\Responses\Common\GenericListResponse;
use App\Http\Responses\Common\GenericObjectResponse;
use App\Http\Responses\Common\IntegerResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface IBaseService
{
    public function setMessageResponse(BaseResponse $response,
                                       string|array $message = null,
                                       string $type,
                                       int $codeStatus);

    public function setIntegerResponse(IntegerResponse $response,
                                       int $result,
                                       string $type,
                                       int $codeStatus): IntegerResponse;

    public function setBooleanResponse(BooleanResponse $response,
                                       bool $result,
                                       string $type,
                                       int $codeStatus): BooleanResponse;

    public function setGenericObjectResponse(GenericObjectResponse $response,
                                             Model|null $dto,
                                             string $type,
                                             int $codeStatus): GenericObjectResponse;

    public function setGenericListResponse(GenericListResponse $response,
                                           Collection $dtoList,
                                           string $type,
                                           int $codeStatus): GenericListResponse;

    public function setGenericListBySearchResponse(GenericListBySearchResponse $response,
                                                   Collection $dtoListBySearch,
                                                   string $type,
                                                   int $codeStatus,
                                                   int $totalCount): GenericListBySearchResponse;

    public function setGenericListBySearchAndPaginationResponse(GenericListBySearchAndPaginationResponse $response,
                                                                Collection $dtoListBySearchAndPagination,
                                                                string $type,
                                                                int $codeStatus,
                                                                int $totalCount,
                                                                array $meta): GenericListBySearchAndPaginationResponse;
}
