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
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Response;

class CompanyContactsApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return ContactResourceCollection()
     */
    public function index(Request $request, Company $company)
    {
        return new ContactResourceCollection($company->contacts()->orderBy('first_name')->get());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function destroy(Company $company, Contact $contact)
    {
        $company->contacts()->detach($contact);

        return Redirect::back()
            ->with('flash.banner', "{$contact->first_name} {$contact->last_name} has been detached.")
            ->with('flash.bannerStyle', 'success');
    }
}
