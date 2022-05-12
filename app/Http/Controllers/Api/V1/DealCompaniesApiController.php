<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\Api\V1\CompanyResourceCollection;
use App\Models\Company;
use App\Models\Deal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DealCompaniesApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return CompanyResourceCollection()
     */
    public function index(Request $request, Deal $deal)
    {
        return new CompanyResourceCollection($deal->companies()->orderBy('name')->get());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Deal $deal
     * @param Company $company
     * @return RedirectResponse
     */
    public function detach(Deal $deal, Company $company)
    {
        $deal->companies()->detach($company);

        return Redirect::back()
            ->with('flash.banner', "{$company->name} is no longer associated with this deal.")
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Associate the specified contact with this resource.
     *
     * @param Company $company
     * @param Deal $deal
     *
     * @return RedirectResponse
     */
    public function attach(Deal $deal, Company $company)
    {
        $deal->companies()->attach($company);

        return Redirect::back()
            ->with('flash.banner', "{$company->name} is now associated with {$deal->name}.")
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Create a new contact and associate it with this deal
     *
     * @param StoreCompanyRequest $request
     * @param Deal $deal
     * @return RedirectResponse
     */
    public function store(StoreCompanyRequest $request, Deal $deal)
    {
        $company = $deal->companies()->create(array_merge($request->validated(), [
            'team_id' => Auth::id(),
            'created_by_id' => Auth::id(),
        ]));

        return Redirect::back()
            ->with('flash.banner', "{$company->name} is now associated with {$deal->name}.")
            ->with('flash.bannerStyle', 'success');
    }
}
