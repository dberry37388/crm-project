<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Resources\Api\V1\NoteResourceCollection;
use App\Models\Company;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CompanyNotesApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return NoteResourceCollection()
     */
    public function index(Request $request, Company $company)
    {
        return new NoteResourceCollection($company->notes()->orderBy('updated_at', 'desc')->get());
    }

    public function store(StoreNoteRequest $request, Company $company)
    {
        $note = $company->notes()->create(array_merge($request->validated(), [
            'created_by_id' => Auth::id()
        ]));

        activity()->performedOn($company)
            ->causedBy(Auth::user())
            ->withProperties([
                'model_type' => 'App\Note',
                'model_id' => $note->id,
                'content' => $note->note,
            ])
            ->log('added a new note');

        return Redirect::back()
            ->with('flash.banner', "A New note has been added to {$company->name}.")
            ->with('flash.bannerStyle', 'success');
    }

    public function destroy(Note $note)
    {
        return Redirect::back()
            ->with('flash.banner', "The note was successfully deleted.")
            ->with('flash.bannerStyle', 'success');
    }
}
