<?php

namespace App\Http\Responses\Common;

class StringResponse extends BaseResponse
{
    public string $result;

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult(string $result): void
    {
        $this->result = $result;
    }
}
