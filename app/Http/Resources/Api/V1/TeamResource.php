<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Company;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'companies' => new CompanyResourceCollection($this->whenLoaded('companies')),
            'industries' => new CompanyResourceCollection($this->whenLoaded('industries')),
        ];
    }
}
