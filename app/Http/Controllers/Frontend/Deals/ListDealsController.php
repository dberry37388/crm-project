<?php

namespace App\Http\Controllers\Frontend\Deals;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CompanyResource;
use App\Http\Resources\Api\V1\DealResource;
use App\Models\Company;
use App\Models\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ListDealsController extends Controller
{
    public function __invoke(Request $request)
    {
        return Inertia::render('Deals/ListDeals');
    }
}
