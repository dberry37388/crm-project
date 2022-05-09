<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Requests\Note\UpdateNoteRequest;
use App\Http\Resources\Api\V1\NoteResource;
use App\Http\Resources\Api\V1\NoteResourceCollection;
use App\Models\Note;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;

class NoteApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return NoteResourceCollection
     */
    public function index(Request $request, Model $model)
    {
        return new NoteResourceCollection(
            Note::search($request->get('search'))
                ->where('noteable_type', $this->getNoteableType($model))
        );
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

    /**
     * @param Model $model
     * @return string
     */
    public function getNoteableType(Model $model): string
    {
        return class_basename($model);
    }
}
