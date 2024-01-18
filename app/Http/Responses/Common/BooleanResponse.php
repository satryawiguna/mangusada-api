<?php
namespace App\Http\Responses\Common;

class BooleanResponse extends BaseResponse
{
    public bool $result;

    /**
     * @return bool
     */
    public function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @param bool $result
     */
    public function setResult(bool $result): void
    {
        $this->result = $result;
    }
}
