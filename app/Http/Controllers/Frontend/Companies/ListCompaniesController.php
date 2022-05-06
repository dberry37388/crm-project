<?php

namespace App\Http\Controllers\Frontend\Companies;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CompanyResource;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ListCompaniesController extends Controller
{
    public function __invoke()
    {
        $companies = Company::where('team_id', Auth::user()->current_team_id)
            ->with(['createdBy', 'assignedTo', 'industry'])
            ->get();

        return Inertia::render('Companies/ListCompanies', [
            'companies' => CompanyResource::collection($companies)
        ]);
    }
}
