<?php

namespace App\Http\Controllers\Api\V1\Industry;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Resources\Api\V1\IndustryResourceCollection;
use App\Models\Industry;
use Illuminate\Http\Request;

class GetIndustriesApiController extends BaseApiController
{
    public function __invoke(Request $request)
    {
        return new IndustryResourceCollection(
            Industry::search($request->get('search'))->get()
        );
    }
}
