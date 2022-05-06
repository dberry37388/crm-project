<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class CompanyResource extends JsonResource
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
            'name' => $this->name,
            'team' => new TeamResource($this->whenLoaded('team')),
            'created_by' => new UserResource($this->createdBy),
            'assigned_to' => new UserResource($this->assignedTo),
            'description' => $this->description,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'number_of_employees' => $this->number_of_employees,
            'timezone' => $this->timezone,
            'industry' => new IndustryResource($this->industry),
        ];
    }
}
