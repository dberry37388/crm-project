<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class DealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge($this->all(), [
            'company' => new CompanyResource($this->whenLoaded('company')),
            'created_by' => new UserResource($this->createdBy),
            'owned_by' => new UserResource($this->assignedTo),
        ]);
    }
}
