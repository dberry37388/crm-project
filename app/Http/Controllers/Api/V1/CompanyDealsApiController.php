<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Deal\StoreDealRequest;
use App\Http\Resources\Api\V1\DealResourceCollection;
use App\Models\Deal;
use App\Models\Company;
use App\QueryBuilder\Sorts\RelatedSort;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class CompanyDealsApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return DealResourceCollection()
     */
    public function index(Request $request, Company $company)
    {
        return new DealResourceCollection($company->deals()->orderBy('name')->get());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @param Deal $deal
     * @return RedirectResponse
     */
    public function detach(Company $company, Deal $deal)
    {
        $company->deals()->detach($deal);

        return Redirect::back()
            ->with('flash.banner', "{$deal->name} is no longer associated with this deal.")
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Associate the specified contact with this resource.
     *
     * @param Deal $deal
     * @param Company $company
     *
     * @return RedirectResponse
     */
    public function attach(Company $company, Deal $deal)
    {
        $company->deals()->attach($deal);

        return Redirect::back()
            ->with('flash.banner', "{$deal->name} is now associated with {$company->name}.")
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Create a new contact and associate it with this deal
     *
     * @param StoreDealRequest $request
     * @param Company $company
     * @return RedirectResponse
     */
    public function store(StoreDealRequest $request, Company $company)
    {
        $deal = $company->deals()->create(array_merge($request->validated(), [
            'team_id' => $request->user()->current_team_id,
            'created_by_id' => $request->user()->id,
        ]));

        return Redirect::back()
            ->with('flash.banner', "{$deal->name} is now associated with {$company->name}.")
            ->with('flash.bannerStyle', 'success');
    }
}
