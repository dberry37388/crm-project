<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\Api\V1\CompanyResource;
use App\Http\Resources\Api\V1\CompanyResourceCollection;
use App\Http\Resources\Api\V1\ContactResourceCollection;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Response;

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
}
