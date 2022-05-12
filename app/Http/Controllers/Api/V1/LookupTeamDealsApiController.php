<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\DealResource;
use App\Models\Deal;
use Illuminate\Http\Request;

class LookupTeamDealsApiController extends BaseApiController
{
    public function __invoke(Request $request)
    {
        $deals = Deal::where('team_id', $request->user()->current_team_id)
            ->where('name', $request->get('search'))->get();

        return DealResource::collection($deals);
    }
}
