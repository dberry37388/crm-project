<?php

namespace App\Http\Controllers\Frontend\Companies;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ListCompaniesController extends Controller
{
    public function __invoke(Request $request)
    {
        $companies = Company::where('team_id', Auth::user()->current_team_id)
            ->with(['createdBy', 'assignedTo', 'industry'])
            ->paginate($request->get('per_page', 25));

        return Inertia::render('Companies/ListCompanies', [
            'companies' => CompanyResource::collection($companies)
        ]);
    }
}
