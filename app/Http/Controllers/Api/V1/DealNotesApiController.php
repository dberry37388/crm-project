<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Resources\Api\V1\NoteResourceCollection;
use App\Models\Deal;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DealNotesApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return NoteResourceCollection()
     */
    public function index(Request $request, Deal $deal)
    {
        return new NoteResourceCollection($deal->notes()->orderBy('updated_at', 'desc')->get());
    }

    public function store(StoreNoteRequest $request, Deal $deal)
    {
        $deal->notes()->create(array_merge($request->validated(), [
            'created_by_id' => Auth::id()
        ]));

        return Redirect::back()
            ->with('flash.banner', "A New note has been added to {$deal->name}.")
            ->with('flash.bannerStyle', 'success');
    }
}
