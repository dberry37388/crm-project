<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\ContactResourceCollection;
use App\Models\Deal;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DealContactsApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return ContactResourceCollection()
     */
    public function index(Request $request, Deal $deal)
    {
        return new ContactResourceCollection($deal->contacts()->orderBy('first_name')->get());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Deal $deal
     * @param Contact $contact
     * @return RedirectResponse
     */
    public function detach(Deal $deal, Contact $contact)
    {
        $deal->contacts()->detach($contact);

        return Redirect::back()
            ->with('flash.banner', "{$contact->first_name} {$contact->last_name} is no longer associated with {$deal->name}.")
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Associate the specified contact with this resource.
     *
     * @param Deal $deal
     * @param Contact $contact
     *
     * @return RedirectResponse
     */
    public function attach(Deal $deal, Contact $contact)
    {
        $deal->contacts()->attach($contact);

        return Redirect::back()
            ->with('flash.banner', "{$contact->first_name} {$contact->last_name} is now associated with {$deal->name}.")
            ->with('flash.bannerStyle', 'success');
    }
}
