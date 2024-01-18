<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'email' => $this->email,
            'name' => $this->profile->name,
            'address' => $this->profile->address,
            'phone_number' => $this->profile->phone_number,
            'sim_number' => $this->profile->sim_number
        ];

        return $resource;
    }
}
