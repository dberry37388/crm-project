<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\ActivityResourceCollection;
use App\Models\Deal;
use Illuminate\Http\Request;

class DealActivitiesApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return ActivityResourceCollection()
     */
    public function index(Request $request, Deal $deal)
    {
        return new ActivityResourceCollection(
            $deal
                ->activities()
                ->orderBy('updated_at', 'DESC')
                ->get()
        );
    }
}
