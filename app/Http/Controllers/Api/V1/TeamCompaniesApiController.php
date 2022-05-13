<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\CompanyResourceCollection;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Spatie\QueryBuilder\QueryBuilder;

class TeamCompaniesApiController extends BaseApiController
{
    /**
     * @param Request $request
     *
     * @return CompanyResourceCollection
     */
    public function index(Request $request)
    {
        $companies = QueryBuilder::for(Company::class)
            ->allowedIncludes('team_id', 'deals', 'contacts', 'notes', 'tasks')
            ->allowedFilters(['name', 'city', 'state'])
            ->defaultSort('name')
            ->paginate($request->get('per_page', 25))
            ->appends(request()->query());

        return new CompanyResourceCollection($companies);
    }
}
