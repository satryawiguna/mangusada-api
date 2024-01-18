<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Responses\Common\BaseResponse;
use App\Http\Responses\Common\BooleanResponse;
use App\Http\Responses\Common\GenericListBySearchAndPaginationResponse;
use App\Http\Responses\Common\GenericListBySearchResponse;
use App\Http\Responses\Common\GenericListResponse;
use App\Http\Responses\Common\GenericObjectResponse;
use App\Http\Responses\Common\IntegerResponse;
use App\Http\Responses\Common\StringResponse;
use Illuminate\Http\JsonResponse;

class ApiBaseController extends Controller
{
    protected function getAllJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            "type" => $response->getType(),
            "code_status" => $response->getCodeStatus(),
            "messages" => $response->getMessageResponseAll()
        ], $response->getCodeStatus());
    }

    protected function getAllLatestJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            "type" => $response->getType(),
            "code_status" => $response->getCodeStatus(),
            "message" => $response->getMessageResponseAllLatest()
        ], $response->getCodeStatus());
    }

    protected function getSuccessJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            "meta" => [
                "type" => $response->getType(),
                "code_status" => $response->getCodeStatus()
            ],
            "messages" => $response->getMessageResponseSuccess()
        ], $response->getCodeStatus());
    }

    protected function getSuccessLatestJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            "meta" => [
                "type" => $response->getType(),
                "code_status" => $response->getCodeStatus()
            ],
            "message" => $response->getMessageResponseSuccessLatest()
        ], $response->getCodeStatus());
    }

    protected function getErrorJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            "meta" => [
                "type" => $response->getType(),
                "code_status" => $response->getCodeStatus()
            ],
            "messages" => $response->getMessageResponseError()
        ], $response->getCodeStatus());
    }

    protected function getErrorLatestJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            "meta" => [
                "type" => $response->getType(),
                "code_status" => $response->getCodeStatus()
            ],
            "message" => $response->getMessageResponseErrorLatest()
        ], $response->getCodeStatus());
    }

    protected function getInfoJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            "meta" => [
                "type" => $response->getType(),
                "code_status" => $response->getCodeStatus()
            ],
            "messages" => $response->getMessageResponseInfo()
        ], $response->getCodeStatus());
    }
    
    protected function getInfoLatestJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            "meta" => [
                "type" => $response->getType(),
                "code_status" => $response->getCodeStatus()
            ],
            "message" => $response->getMessageResponseInfoLatest()
        ], $response->getCodeStatus());
    }

    protected function getWarningJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            "meta" => [
                "type" => $response->getType(),
                "code_status" => $response->getCodeStatus()
            ],
            "messages" => $response->getMessageResponseWarning()
        ], $response->getCodeStatus());
    }

    protected function getWarningLatestJsonResponse(BaseResponse $response): JsonResponse
    {
        return response()->json([
            "meta" => [
                "type" => $response->getType(),
                "code_status" => $response->getCodeStatus()
            ],
            "message" => $response->getMessageResponseWarningLatest()
        ], $response->getCodeStatus());
    }

    protected function getJsonResponse(StringResponse|IntegerResponse|BooleanResponse $response,
                                       ?array                                         $meta = null): JsonResponse
    {

        $metaInit = [
            "type" => $response->getType(),
            "code_status" => $response->getCodeStatus()
        ];

        if ($meta) {
            $meta = array_merge($metaInit, $meta);
        } else {
            $meta = $metaInit;
        }

        return response()->json([
            "meta" => $meta,
            "result" => $response->result
        ], $response->getCodeStatus());
    }

    protected function getObjectJsonResponse(GenericObjectResponse $response,
                                             ?string               $resource = null,
                                             ?array                $meta = null): JsonResponse
    {

        $metaInit = [
            "type" => $response->getType(),
            "code_status" => $response->getCodeStatus()
        ];

        if ($meta) {
            $meta = array_merge($metaInit, $meta);
        } else {
            $meta = $metaInit;
        }

        return response()->json([
            "meta" => $meta,
            "result" => ($resource) ? new $resource($response->getDto()) : $response->getDto()
        ], $response->getCodeStatus());
    }

    protected function getListJsonResponse(GenericListResponse $response,
                                           ?string             $resource = null,
                                           ?array              $meta = null): JsonResponse
    {
        $metaInit = [
            "type" => $response->getType(),
            "code_status" => $response->getCodeStatus()
        ];

        if ($meta) {
            $meta = array_merge($metaInit, $meta);
        } else {
            $meta = $metaInit;
        }

        return response()->json([
            "meta" => $meta,
            "result" => ($resource) ? new $resource($response->getDtoList()) : $response->getDtoList()
        ], $response->getCodeStatus());
    }

    protected function getListBySearchJsonResponse(GenericListBySearchResponse $response,
                                                   ?string                     $resource = null,
                                                   ?array                      $meta = null): JsonResponse
    {
        $metaInit = [
            "type" => $response->getType(),
            "code_status" => $response->getCodeStatus(),
            "total_count" => $response->getTotalCount()
        ];

        if ($meta) {
            $meta = array_merge($metaInit, $meta);
        } else {
            $meta = $metaInit;
        }

        return response()->json([
            "meta" => $meta,
            "result" => ($resource) ? new $resource($response->getDtoListBySearch()) : $response->getDtoListBySearch()
        ], $response->getCodeStatus());
    }

    protected function getListBySearchAndPaginationJsonResponse(GenericListBySearchAndPaginationResponse $response,
                                                                ?string                                  $resource = null,
                                                                ?array                                   $meta = null): JsonResponse
    {
        $metaInit = array_merge([
            "type" => $response->getType(),
            "code_status" => $response->getCodeStatus(),
            "total_count" => $response->getTotalCount()
        ], $response->getMeta());

        if ($meta) {
            $meta = array_merge($metaInit, $meta);
        } else {
            $meta = $metaInit;
        }

        return response()->json([
            "meta" => $meta,
            "result" => ($resource) ? new $resource($response->getDtoListBySearchAndPagination()) : $response->getDtoListBySearchAndPagination()
        ], $response->getCodeStatus());
    }
}
