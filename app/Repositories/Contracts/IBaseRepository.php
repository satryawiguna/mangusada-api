<?php

namespace App\Repositories\Contracts;

use App\Http\Requests\Common\ListRequest;
use App\Models\BaseModel;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface IBaseRepository
{
    public function all(ListRequest $request): Collection;

    public function findById(int|string $id): BaseModel|null;

    public function findOrNew(array $data): BaseModel;

    public function count(): int;

    public function create(Request $request): BaseModel;

    public function update(Request $request): BaseModel|null;

    public function delete(int|string $id): BaseModel|null;
}
