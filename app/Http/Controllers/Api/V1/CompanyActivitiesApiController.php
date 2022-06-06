<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\ActivityResourceCollection;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyActivitiesApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return ActivityResourceCollection()
     */
    public function index(Request $request, Company $company)
    {
        return new ActivityResourceCollection(
            $company
                ->activities()
                ->orderBy('updated_at', 'DESC')
                ->get()
        );
    }
}
