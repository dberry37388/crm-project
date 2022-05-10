<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Resources\Api\V1\TaskResourceCollection;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CompanyTasksApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return TaskResourceCollection()
     */
    public function index(Request $request, Company $company)
    {
        return new TaskResourceCollection($company->tasks()->orderBy('updated_at', 'desc')->get());
    }

    public function store(StoreTaskRequest $request, Company $company)
    {
        $company->tasks()->create(array_merge($request->validated(), [
            'created_by_id' => Auth::id()
        ]));

        return Redirect::back()
            ->with('flash.banner', "A new task has been added to {$company->name}.")
            ->with('flash.bannerStyle', 'success');
    }
}
