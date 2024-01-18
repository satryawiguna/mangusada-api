<?php
namespace App\Http\Responses\Common;

class GenericObjectResponse extends BaseResponse
{
    public $dto;

    public function getDto()
    {
        return $this->dto ?? new \stdClass();
    }
}
