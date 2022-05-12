<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\DealResourceCollection;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamDealsApiController extends BaseApiController
{
    /**
     * @param Request $request
     *
     * @return DealResourceCollection
     */
    public function index(Request $request)
    {
        return new DealResourceCollection(
            Deal::where(function($query) use($request) {
                return $query
                    ->where('name', 'like', "%{$request->get('query')}");
            })
                ->where('team_id', Auth::user()->current_team_id)
                ->get()
        );
    }
}
