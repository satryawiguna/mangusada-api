<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\RegisterRequest;
use Illuminate\Database\Eloquent\Model;

interface IUserRepository
{
    public function register(RegisterRequest $request): Model;
}
