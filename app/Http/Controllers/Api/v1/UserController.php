<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RegisterResource;
use App\Services\Contracts\IUserService;
use Mockery\Exception;

class UserController extends ApiBaseController
{
    private readonly IUserService $_userService;

    public function __construct(IUserService $userService)
    {
        $this->_userService = $userService;
    }

    public function register(RegisterRequest $request)
    {
        $registerResponse = $this->_userService->register($request);

        if ($registerResponse->isError()) {
            return $this->getErrorLatestJsonResponse($registerResponse);
        }

        return $this->getObjectJsonResponse($registerResponse, RegisterResource::class);
    }
}
