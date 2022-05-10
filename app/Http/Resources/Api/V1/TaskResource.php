<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class TaskResource extends JsonResource
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
            'due_date' => $this->due_date,
            'completed_at' => $this->completed_at,
            'task' => $this->task,
            'created_by' => new UserResource($this->createdBy),
            'assigned_to' => new UserResource($this->assignedTo),
            'notes' => $this->notes,
            'is_done' => $this->isDone(),
            'priority' => $this->priority,
            'parent_type' => $this->taskable_type,
            'parent_id' => $this->taskable_id,
        ];
    }
}
