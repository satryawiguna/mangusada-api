<?php

namespace App\Services\Contracts;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Responses\Common\BaseResponse;
use App\Http\Responses\Common\GenericObjectResponse;

interface IUserService
{
    public function register(RegisterRequest $request): GenericObjectResponse;

    public function login(LoginRequest $request): GenericObjectResponse;

    public function logout(): BaseResponse;
}
