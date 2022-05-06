<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\IndustryResource;
use App\Models\Industry;
use Illuminate\Support\Facades\Auth;

class LookupIndustriesApiController extends BaseApiController
{
    public function __invoke()
    {
        $industries = Industry::where('team_id', Auth::user()->current_team_id)
            ->orderBy('name', 'asc')
            ->get();

        return IndustryResource::collection($industries);
    }
}
