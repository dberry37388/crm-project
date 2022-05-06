<?php

namespace App\Http\Controllers\Api\V1\Industry;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Industry\StoreIndustryRequest;
use App\Http\Resources\Api\V1\IndustryResource;
use App\Models\Industry;
use Illuminate\Http\Request;

class StoreIndustryApiController extends BaseApiController
{
    public function __invoke(StoreIndustryRequest $request)
    {
        $industry = Industry::create([
            'team_id' => $request->user()->current_team_id,
            'created_by_id' => $request->user()->id,
            'name' => $request->get('name'),
        ]);

        return new IndustryResource($industry);
    }
}
