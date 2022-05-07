<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\Api\V1\CompanyResource;
use App\Http\Resources\Api\V1\CompanyResourceCollection;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Response;

class CompanyApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return CompanyResourceCollection()
     */
    public function index(Request $request)
    {
        return new CompanyResourceCollection(
            Company::search($request->get('search'))
                ->where('team_id', $request->user()->current_team_id)
                ->paginate($request->get('per_page', 25))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompanyRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create(array_merge($request->validated(), [
            'team_id' => $request->user()->current_team_id,
            'created_by_id' => $request->user()->id,
        ]));

        return Redirect::to(route('companies.show', $company))
            ->with('flash.banner', "{$company->name} Created")
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  Company  $company
     * @return CompanyResource
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCompanyRequest $request
     * @param Company $company
     * @return CompanyResource|RedirectResponse
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update($request->validated());

        return $request->wantsJson()
            ? new CompanyResource($company)
            : back()->with('status', 'company-updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return RedirectResponse
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return Redirect::to(route('companies.list'))
            ->with('flash.banner', "{$company->name} Deleted")
            ->with('flash.bannerStyle', 'success');
    }
}
