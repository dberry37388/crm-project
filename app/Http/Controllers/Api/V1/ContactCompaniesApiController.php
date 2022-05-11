<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Http\Resources\Api\V1\CompanyResource;
use App\Http\Resources\Api\V1\CompanyResourceCollection;
use App\Http\Resources\Api\V1\ContactResourceCollection;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Response;

class ContactCompaniesApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return CompanyResourceCollection()
     */
    public function index(Request $request, Contact $contact)
    {
        return new CompanyResourceCollection($contact->companies()->orderBy('name')->get());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @param Contact $contact
     *
     * @return RedirectResponse
     */
    public function detach(Contact $contact, Company $company)
    {
        $contact->companies()->detach($company);

        return Redirect::back()
            ->with('flash.banner', "{$company->name} has been detached.")
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Associate the specified contact with this resource.
     *
     * @param Contact $contact
     * @param Company $company
     *
     * @return RedirectResponse
     */
    public function attach(Contact $contact, Company $company)
    {
        $contact->companies()->attach($company);

        return Redirect::back()
            ->with('flash.banner', "{$contact->first_name} {$contact->last_name} is now associated with {$company->name}.")
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Create a new contact and associate it with this contact
     *
     * @param StoreCompanyRequest $request
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function store(StoreCompanyRequest $request, Contact $contact)
    {
        $company = $contact->companies()->create(array_merge($request->validated(), [
            'team_id' => Auth::id(),
            'created_by_id' => Auth::id(),
        ]));

        return Redirect::back()
            ->with('flash.banner', "{$company->name} is now associated with {$contact->first_name} {$contact->last_name}.")
            ->with('flash.bannerStyle', 'success');
    }
}
