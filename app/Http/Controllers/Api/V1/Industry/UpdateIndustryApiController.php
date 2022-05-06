<?php

namespace App\Http\Controllers\Api\V1\Industry;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Industry\StoreIndustryRequest;
use App\Http\Requests\Industry\UpdateIndustryRequest;
use App\Http\Resources\Api\V1\IndustryResource;
use App\Models\Industry;
use Illuminate\Http\Request;

class UpdateIndustryApiController extends BaseApiController
{
    public function __invoke(UpdateIndustryRequest $request, Industry $industry)
    {
        $industry->update([
            'name' => $request->get('name'),
        ]);

        return new IndustryResource($industry);
    }
}
