<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Requests\Note\UpdateNoteRequest;
use App\Http\Resources\Api\V1\NoteResource;
use App\Http\Resources\Api\V1\NoteResourceCollection;
use App\Http\Resources\Api\V1\TaskResourceCollection;
use App\Models\Note;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Spatie\QueryBuilder\QueryBuilder;

class NoteApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return NoteResourceCollection
     */
    public function index(Request $request, Model $model)
    {
        $notes = QueryBuilder::for(Note::class)
            ->allowedIncludes('deals', 'contacts', 'notes', 'tasks')
            ->allowedFilters(['note', 'due_date', 'priority'])
            ->defaultSort('note')
            ->paginate($request->get('per_page', 25))
            ->appends(request()->query());

        return new NoteResourceCollection($notes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreNoteRequest $request
     * @param Model $model
     * @return RedirectResponse
     */
    public function store(StoreNoteRequest $request, Model $model)
    {
        $contact = Note::create(array_merge($request->validated(), [
            'noteable_type' => $this->getNoteableType($model),
            'noteable_id' => $model->id,
            'created_by_id' => $request->user()->id,
        ]));

        return Redirect::back()
            ->with('flash.banner', "New note has been added.")
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param Note $note
     * @return NoteResource
     */
    public function show(Note $note)
    {
        return new NoteResource($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateNoteRequest $request
     * @param Note $note
     * @return RedirectResponse
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $note->update($request->validated());

        return Redirect::back()
            ->with('flash.banner', "Note has been updated.")
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Note $note
     * @return RedirectResponse
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return Redirect::back()
            ->with('flash.banner', "Note has been deleted.")
            ->with('flash.bannerStyle', 'success');
    }
}
