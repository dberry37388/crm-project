<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\Api\V1\CompanyResourceCollection;
use App\Http\Resources\Api\V1\TaskResource;
use App\Http\Resources\Api\V1\TaskResourceCollection;
use App\Models\Company;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\QueryBuilder\QueryBuilder;

class TaskApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Model $model
     * @return TaskResourceCollection
     */
    public function index(Request $request, Model $model)
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedIncludes('deals', 'contacts', 'notes', 'tasks')
            ->allowedFilters(['task', 'notes', 'due_date', 'priority'])
            ->defaultSort('task')
            ->paginate($request->get('per_page', 25))
            ->appends(request()->query());

        return new TaskResourceCollection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequest $request
     * @param Model $model
     * @return RedirectResponse
     */
    public function store(StoreTaskRequest $request, Model $model): RedirectResponse
    {
        $contact = Task::create(array_merge($request->validated(), [
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
     * @param  Task  $task
     * @return TaskResource
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return RedirectResponse
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return Redirect::back()
            ->with('flash.banner', "Task has been updated.")
            ->with('flash.bannerStyle', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return RedirectResponse
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return Redirect::back()
            ->with('flash.banner', "Note has been deleted.")
            ->with('flash.bannerStyle', 'success');
    }
}
