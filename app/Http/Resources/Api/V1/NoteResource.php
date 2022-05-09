<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Company;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => new UserResource($this->createdBy),
            'note' => $this->note,
        ];
    }

    /**
     * @throws Exception
     */
    protected function getResource($noteableType, $noteableId)
    {
        return match ($noteableType) {
            "App\Models\Company" => new CompanyResource(Company::find($noteableId)),
            "App\Models\Contact" => new ContactResource(Contact::find($noteableId)),
            default => throw new Exception("Could not find a valid resource."),
        };
    }
}
