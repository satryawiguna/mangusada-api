<?php

namespace App\Http\Resources\Reservation;

use App\Http\Resources\Car\CarResource;
use App\Http\Resources\UserProfileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckOutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $resource = [
            'id' => $this->id,
            'car' => new CarResource($this['car']),
            'user' => new UserProfileResource($this['userProfile']),
            'checkout_start_date' => $this->checkout_start_date,
            'checkout_end_date' => $this->checkout_end_date,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at->timestamp,
            'updated_at' => $this->updated_at->timestamp,
        ];

        return $resource;
    }
}
