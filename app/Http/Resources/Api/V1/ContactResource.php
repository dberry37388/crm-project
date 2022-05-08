<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'team' => new TeamResource($this->whenLoaded('team')),
            'created_by' => new UserResource($this->createdBy),
            'assigned_to' => new UserResource($this->assignedTo ?? []),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'job_title' => $this->job_title,
            'phone_number' => $this->phone_number,
            'mobile_number' => $this->mobile_number,
            'description' => $this->description,
        ];
    }
}
