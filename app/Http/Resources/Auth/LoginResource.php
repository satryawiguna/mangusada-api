<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
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
            'id' => $this['id'],
            'email' => $this['email'],
            'role' => new RoleResource($this['role']),
            'access_token' => $this['access_token'],
            'token_type' => $this['token_type']
        ];

        return $resource;
    }
}
