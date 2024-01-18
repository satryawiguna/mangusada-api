<?php

namespace App\Http\Resources\Car;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CarCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $resources = $this->collection->map(function ($value, $key) {
            return [
                'id' => $value->id,
                'brand' => $value->brand,
                'model' => $value->model,
                'year' => $value->year,
                'license_plate' => $value->license_plate,
                'rental_rate' => $value->rental_rate,
                'created_by' => $value->created_by,
                'updated_by' => $value->updated_by,
                'created_at' => $value->created_at->timestamp,
                'updated_at' => $value->updated_at->timestamp,
            ];
        });

        return $resources->toArray();
    }
}
