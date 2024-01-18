<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Common\BaseRequest;

class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'identity' => ['required', 'string'],
            'password' => ['required']
        ];
    }
}
