<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => 'Auth',
            'attributes' => [
                'username' => $this->username,
                'name' => $this->name,
                'email' => $this->email,
                'role_id' => $this->role_id,
                'profile_photo_url' => $this->profile_photo_url,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
            'relationships' => [
                'role' => new RoleUserResource($this->whenLoaded('role')),
            ]
        ];
    }
}
