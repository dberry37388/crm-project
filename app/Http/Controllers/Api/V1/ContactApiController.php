<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Http\Resources\Api\V1\ContactResource;
use App\Http\Resources\Api\V1\ContactResourceCollection;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ContactApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ContactResourceCollection
     */
    public function index(Request $request)
    {
        $contacts = QueryBuilder::for(Contact::class)
            ->allowedIncludes('deals', 'companies', 'notes', 'tasks')
            ->allowedFilters(['first_name', 'last_name', 'city', 'state', AllowedFilter::scope('search_by_name')])
            ->defaultSort('first_name')
            ->paginate($request->get('per_page', 25))
            ->appends(request()->query());

        return new ContactResourceCollection($contacts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreContactRequest $request
     * @return RedirectResponse
     */
    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create(array_merge($request->validated(), [
            'team_id' => $request->user()->current_team_id,
            'created_by_id' => $request->user()->id,
        ]));

        if ($request->has('company_id')) {
            $contact->companies()->attach($request->get('company_id'));
        }

        return Redirect::to(route('contacts.show', $contact))
            ->with('flash.banner', "{$contact->first_name} {$contact->last_name} Created")
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param Contact $contact
     * @return ContactResource
     */
    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateContactRequest $request
     * @param Contact $contact
     * @return ContactResource|RedirectResponse
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contact->update($request->validated());

        return $request->wantsJson()
            ? new ContactResource($contact)
            : back()
                ->with('flash.banner', "{$contact->first_name} {$contact->last_name} Updated")
                ->with('flash.bannerStyle', 'success');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return Redirect::to(route('contacts.list'))
            ->with('flash.banner', "{$contact->first_name} {$contact->last_name} Deleted")
            ->with('flash.bannerStyle', 'success');
    }
}
