<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class IndustryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    #[ArrayShape(['name' => "mixed", 'team' => "\App\Http\Resources\Api\V1\TeamResource", 'created_by' => "\App\Http\Resources\Api\V1\UserResource"])] public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'team' => new TeamResource($this->team),
            'created_by' => new UserResource($this->createdBy)
        ];
    }
}
