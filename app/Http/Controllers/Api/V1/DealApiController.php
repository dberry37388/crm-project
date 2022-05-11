<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deal\StoreDealRequest;
use App\Http\Requests\Deal\UpdateDealRequest;
use App\Http\Resources\Api\V1\DealResource;
use App\Http\Resources\Api\V1\DealResourceCollection;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class DealApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return DealResourceCollection
     */
    public function index(Request $request)
    {
        return new DealResourceCollection(
            Deal::search($request->get('search'))
                ->where('team_id', $request->user()->current_team_id)
                ->paginate($request->get('per_page', 25))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDealRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDealRequest $request)
    {
        $deal = Deal::create(array_merge($request->validated(), [
            'team_id' => $request->user()->current_team_id,
            'created_by_id' => $request->user()->id,
        ]));

        return Redirect::to(route('deals.show', $deal))
            ->with('flash.banner', "New deal ({$deal->name} created")
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param Deal $deal
     * @return DealResource
     */
    public function show(Deal $deal)
    {
        return new DealResource($deal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDealRequest $request
     * @param Deal $deal
     * @return Response
     */
    public function update(UpdateDealRequest $request, Deal $deal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Deal $deal
     * @return Response
     */
    public function destroy(Deal $deal)
    {
        //
    }
}
