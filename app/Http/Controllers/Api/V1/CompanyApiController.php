<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\Api\V1\CompanyResource;
use App\Http\Resources\Api\V1\CompanyResourceCollection;
use App\Models\Company;
use App\QueryBuilder\Sorts\RelatedSort;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Response;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class CompanyApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return CompanyResourceCollection()
     */
    public function index(Request $request)
    {
        $companies = QueryBuilder::for(Company::class)
            ->where('team_id', Auth::user()->current_team_id)
            ->allowedIncludes('team_id', 'deals', 'contacts', 'notes', 'tasks')
            ->allowedFilters(['name', 'city', 'state', 'created_by_id', 'assigned_to_id'])
            ->allowedSorts(
                'name',
                'city',
                'state',
                'created_at',
                'updated_at',
                AllowedSort::custom("industry.name", new RelatedSort()),
                AllowedSort::custom("assignedTo.name", new RelatedSort()),
                AllowedSort::custom("createdBy.name", new RelatedSort()),
            )
            ->defaultSort('name')
            ->paginate($request->get('per_page', 25))
            ->appends(request()->query());

        $companies->withPath('/companies?' . $request->query('sort'));

        return new CompanyResourceCollection($companies);
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
            'created_by_id' => Auth::user()->id,
        ]));

        if ($request->has('contact_id') && !empty($request->get('contact_id'))) {
            $company->contacts()->attach($request->get('contact_id'));

            return Redirect::back()
                ->with('flash.banner', "Contact is now associated with {$company->name}")
                ->with('flash.bannerStyle', 'success');
        }

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
            : back()->with('flash.banner', "{$company->name} has been updated.")
                ->with('flash.bannerStyle', 'success');
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
