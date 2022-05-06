<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Industry\StoreIndustryRequest;
use App\Http\Requests\Industry\UpdateIndustryRequest;
use App\Http\Resources\Api\V1\IndustryResource;
use App\Http\Resources\Api\V1\IndustryResourceCollection;
use App\Models\Industry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Response;

class IndustryApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return IndustryResourceCollection
     */
    public function index(Request $request)
    {
        return new IndustryResourceCollection(
            Industry::search($request->get('search'))
                ->where('team_id', $request->user()->id)
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreIndustryRequest $request
     * @return IndustryResource
     */
    public function store(StoreIndustryRequest $request)
    {
        $industry = Industry::create([
            'team_id' => $request->user()->current_team_id,
            'created_by_id' => $request->user()->id,
            'name' => $request->get('name'),
        ]);

        return new IndustryResource($industry);
    }

    /**
     * Display the specified resource.
     *
     * @param  Industry  $industry
     * @return IndustryResource
     */
    public function show(Industry $industry)
    {
        return new IndustryResource($industry);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateIndustryRequest $request
     * @param Industry $industry
     * @return IndustryResource
     */
    public function update(UpdateIndustryRequest $request, Industry $industry)
    {
        $industry->update([
            'name' => $request->get('name'),
        ]);

        return new IndustryResource($industry);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Industry $industry
     * @return JsonResponse
     */
    public function destroy(Industry $industry)
    {
        $industry->companies()->each(function ($company) {
            $company->update([
                'industry_id' => null
            ]);
        });

        $industry->delete();

        return Response::json([], 204);
    }
}
