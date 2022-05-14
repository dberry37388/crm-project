<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deal\StoreDealRequest;
use App\Http\Requests\Deal\UpdateDealRequest;
use App\Http\Resources\Api\V1\DealResource;
use App\Http\Resources\Api\V1\DealResourceCollection;
use App\Models\Deal;
use App\QueryBuilder\Sorts\RelatedSort;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class DealApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return DealResourceCollection
     */
    public function index(Request $request)
    {
        $contacts = QueryBuilder::for(Deal::class)
            ->allowedIncludes('contacts', 'companies', 'notes', 'tasks')
            ->allowedFilters(['name', 'amount', 'stage', 'priority', 'type', 'owned_by_id', 'created_by_id'])
            ->defaultSort('updated_at')
            ->allowedSorts(
                'name',
                'amount',
                'stage',
                'priority',
                'type',
                'created_at',
                'updated_at',
                AllowedSort::custom("ownedBy.name", new RelatedSort()),
                AllowedSort::custom("createdBy.name", new RelatedSort()),
            )
            ->paginate($request->get('per_page', 25))
            ->appends(request()->query());

        return new DealResourceCollection($contacts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDealRequest $request
     * @return RedirectResponse
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
     * @return DealResource|RedirectResponse
     */
    public function update(UpdateDealRequest $request, Deal $deal)
    {
        $deal->update($request->validated());

        return $request->wantsJson()
            ? new DealResource($deal)
            : back()
                ->with('flash.banner', "{$deal->name} Updated")
                ->with('flash.bannerStyle', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Deal $deal
     * @return RedirectResponse
     */
    public function destroy(Deal $deal)
    {
        $deal->delete();

        return Redirect::to(route('deals.list'))
            ->with('flash.banner', "{$deal->name} Deleted")
            ->with('flash.bannerStyle', 'success');
    }
}
