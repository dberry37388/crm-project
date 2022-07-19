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
        return [
            'id' => $this->id,
            'team_id' => $this->team_id,
            'assigned_to_id' => $this->assigned_to_id,
            'assigned_to' => new UserResource($this->assignedTo),
            'owned_by_id' => $this->owned_by_id,
            'name' => $this->name,
            'type' => $this->type,
            'stage' => $this->stage,
            'priority' => $this->priority,
            'amount' => $this->amount,
            'close_date' => ! empty($this->close_date) ? $this->close_date->toDateString() : '',
            'created_by' => new UserResource($this->createdBy),
            'owned_by' => new UserResource($this->ownedBy),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'contacts' => new ContactResourceCollection($this->contacts)
        ];
    }
}
