<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Task::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        try {
            $project = Project::find($request->project_id);
            $project->tasks()->create($request->validated());

            return response(__('messages.created', ['resource' => 'tarefa']));
        } catch (\Exception $error) {
            return response(__('messages.created', ['resource' => 'tarefa']));
        }

        return response(__('messages.created', ['resource' => 'tarefa']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        try {
            $task->update($request->validated());

            return response(__('messages.updated', ['resource' => 'tarefa']));
        } catch (\Exception $error) {
            return response(__('messages.updated', ['resource' => 'tarefa']));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();

            return response(__('messages.deleted', ['resource' => 'tarefa']));
        } catch (\Exception $error) {
            return response(__('messages.deleted', ['resource' => 'tarefa']));
        }
    }
}
