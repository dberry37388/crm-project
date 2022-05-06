<?php

namespace App\Http\Controllers\Frontend\Companies;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CompanyResource;
use App\Models\Company;
use Inertia\Inertia;

class ShowCompanyController extends Controller
{
    public function __invoke(int $company)
    {
        $company = Company::with(['createdBy', 'assignedTo', 'industry'])->findOrFail($company);

        return Inertia::render('Companies/ShowCompany', [
            'company' => new CompanyResource($company)
        ]);
    }
}
