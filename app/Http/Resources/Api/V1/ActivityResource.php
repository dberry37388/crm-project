<?php

namespace App\Http\Resources\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

class ActivityResource extends JsonResource
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
            'team' => new TeamResource($this->whenLoaded('team')),
            'log_name' => $this->log_name,
            'description' => $this->description,
            'subject_type' => $this->subject_type,
            'subject_id' => $this->subject_id,
            'subject' => $this->getResourceFromSubjectType($this->subject_type),
            'event' => $this->event,
            'causer_type' => $this->causer_type,
            'causer_id' => $this->causer_id,
            'causer' => new UserResource($this->causer),
            'properties' => $this->properties,
            'batch_uuid' => $this->batch_uuid,
            'created_at' => Carbon::parse($this->created_at)->toW3cString(),
            'updated_at' => Carbon::parse($this->updated_at)->toW3cString(),
        ];
    }

    protected function getResourceFromSubjectType($subject, $secondary = false)
    {
        $resourceClass = $this->getResourceClass($subject);

        if (class_exists($resourceClass)) {
            return new $resourceClass($this->subject);
        }

        return null;
    }

    /**
     * @param $subject
     * @return string
     */
    public function getResourceClass($subject): string
    {
        $string = str_replace('App\Models\\', 'App\Http\Resources\Api\V1\\', $subject);
        return $string . 'Resource';
    }
}
