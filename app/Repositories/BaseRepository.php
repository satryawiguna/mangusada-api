<?php

namespace App\Repositories;

use App\Http\Requests\Common\ListRequest;
use App\Models\BaseModel;
use App\Repositories\Contracts\IBaseRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BaseRepository implements IBaseRepository
{
    protected readonly BaseModel $_model;

    public function __construct(BaseModel $model)
    {
        $this->_model = $model;
    }

    public function findById(int|string $id): BaseModel|null
    {
        return $this->_model->find($id);
    }

    public function findOrNew(array $data): BaseModel
    {
        $model = $this->_model->firstOrNew($data);

        $model->save();

        return $model->fresh();
    }

    public function count(): int
    {
        return $this->_model->get()
            ->count();
    }

    public function create(Request $request): BaseModel
    {
        $model = $this->_model->fill($request->all());

        $this->setAuditableInformationFromRequest($model, $request);

        $model->save();

        return $model->fresh();
    }

    public function all(ListRequest $request): Collection
    {
        return $this->_model
            ->orderBy($request->order_by, $request->sort)
            ->get();
    }

    protected function setAuditableInformationFromRequest(BaseModel|array $entity, $request)
    {
        if ($entity instanceof BaseModel) {
            if (!$entity->getKey()) {
                $entity->setCreatedInfo($request->request_by);
            } else {
                $entity->setUpdatedInfo($request->request_by);
            }
        }

        if (is_array($entity)) {
            if (!array_key_exists('id', $entity) || $entity['id'] == 0) {
                $entity['created_by'] = $request->request_by;
                $entity['created_at'] = Carbon::now()->toDateTimeString();
            } else {
                $entity['updated_by'] = $request->request_by;
                $entity['updated_at'] = Carbon::now()->toDateTimeString();
            }

            return $entity;
        }
    }

    public function update(Request $request): BaseModel|null
    {
        $model = $this->_model->find($request->id);

        if (!$model) {
            return null;
        }

        $this->setAuditableInformationFromRequest($model, $request);

        $model->update($request->all());

        return $model->fresh();
    }

    public function delete(int|string $id): BaseModel|null
    {
        $model = $this->_model->find($id);

        if (!$model) {
            return null;
        }

        $model->delete();

        return $model;
    }
}
