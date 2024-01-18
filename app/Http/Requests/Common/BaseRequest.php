<?php

namespace App\Http\Requests\Common;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            "meta" => [
                "type" => "ERROR",
                "code_status" => 422
            ],
            "errors" => $validator->errors()
        ], 422);

        throw new HttpResponseException($response);
    }
}
