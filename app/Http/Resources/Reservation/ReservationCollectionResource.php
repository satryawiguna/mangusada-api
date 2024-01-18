<?php

namespace App\Http\Resources\Reservation;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReservationCollectionResource extends ResourceCollection
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
                'checkout_start_date' => $value->checkout_start_date,
                'checkout_end_date' => $value->checkout_end_date,
                'checkin_date' => $value->checkin_date,
                'total_duration' => $value->total_duration,
                'total_cost' => $value->total_cost,
                'created_by' => $value->created_by,
                'modified_by' => $value->modified_by,
                'created_at' => $value->created_at->timestamp,
                'updated_at' => $value->updated_at->timestamp,
            ];
        });

        return $resources->toArray();
    }
}
