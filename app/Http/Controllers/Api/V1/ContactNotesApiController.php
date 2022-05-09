<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Resources\Api\V1\NoteResourceCollection;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ContactNotesApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return NoteResourceCollection()
     */
    public function index(Request $request, Contact $contact)
    {
        return new NoteResourceCollection($contact->notes()->orderBy('updated_at', 'desc')->get());
    }

    public function store(StoreNoteRequest $request, Contact $contact)
    {
        $contact->notes()->create(array_merge($request->validated(), [
            'created_by_id' => Auth::id()
        ]));

        return Redirect::back()
            ->with('flash.banner', "A New note has been added to {$contact->first_name} {$contact->last_name}.")
            ->with('flash.bannerStyle', 'success');
    }
}
