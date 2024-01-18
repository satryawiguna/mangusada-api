<?php

namespace App\Services;

use App\Enums\HttpResponseType;
use App\Exceptions\InvalidLoginAttemptException;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Responses\Common\BaseResponse;
use App\Http\Responses\Common\GenericObjectResponse;
use App\Repositories\Contracts\IUserRepository;
use App\Services\Contracts\IUserService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserService extends BaseService implements IUserService
{
    private readonly IUserRepository $_userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->_userRepository = $userRepository;
    }

    public function register(RegisterRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            DB::beginTransaction();

            $register = $this->_userRepository->register($request);

            DB::commit();

            $this->setGenericObjectResponse($response,
                $register,
                'SUCCESS',
                HttpResponseType::SUCCESS->value);
        } catch (QueryException $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                $ex->getMessage(),
                'ERROR',
                HttpResponseType::BAD_REQUEST->value);
        } catch (Exception $ex) {
            DB::rollBack();

            $this->setMessageResponse($response,
                'Something went wrong',
                'ERROR',
                HttpResponseType::INTERNAL_SERVER_ERROR->value);
        }

        return $response;
    }

    public function login(LoginRequest $request): GenericObjectResponse
    {
        $response = new GenericObjectResponse();

        try {
            $identity = (filter_var($request->identity, FILTER_VALIDATE_EMAIL)) ? 'email' : 'username';

            if (!Auth::attempt([$identity => $request->identity, "password" => $request->password])) {
                throw new InvalidLoginAttemptException('Invalid login attempt');
            }

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            $this->setGenericObjectResponse($response,
                [
                    'id' => $user->id,
                    'email' => $user->email,
                    'username' => $user->username,
                    'role' => $user->role,
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ],
                'SUCCESS',
                HttpResponseType::SUCCESS->value);
        } catch (InvalidLoginAttemptException $ex) {
            $this->setMessageResponse($response,
                "Invalid login attempt",
                "ERROR",
                HttpResponseType::UNAUTHORIZED->value);
        } catch (ValidationException $ex) {
            $this->setMessageResponse($response,
                $ex->getMessage(),
                'ERROR',
                HttpResponseType::BAD_REQUEST->value);
        } catch (\Exception $ex) {
            $this->setMessageResponse($response,
                'Something went wrong',
                'ERROR',
                HttpResponseType::INTERNAL_SERVER_ERROR->value);
        }

        return $response;
    }

    public function logout(): BaseResponse
    {
        $response = new BaseResponse();

        try {
            Auth::user()->tokens()->delete();

            $this->setMessageResponse($response,
                'Logout succeed',
                'SUCCESS',
                HttpResponseType::SUCCESS->value);
        } catch (\Exception $ex) {
            $this->setMessageResponse($response,
                'Something went wrong',
                'ERROR',
                HttpResponseType::INTERNAL_SERVER_ERROR->value);
        }

        return $response;
    }

}
