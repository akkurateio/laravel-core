<?php

namespace Akkurate\LaravelCore\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'is_active' => $this->is_active,
            'account' => $this->account,
            'roles' => $this->roles,
            'addresses' => $this->addresses,
            'phones' => $this->phones,
            'emails' => $this->emails,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
