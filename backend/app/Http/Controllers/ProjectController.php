<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Enums\UserPermission;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;

class ProjectController extends Controller
{

    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Project::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return ProjectResource::collection($request->user()->projects()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        try {
            $project = Project::create($request->validated());

            $request->user()
                ->projects()
                ->attach($project, [
                    'permission' => UserPermission::OWNER->value
                ]);
            return response(__('messages.created', ['resource' => 'projeto']));
        } catch (\Exception $error) {
            return response(__('messages.create_failed', ['resource' => 'projeto']), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Project $project)
    {
        $request->user()->pushOpenedProject($project);
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        try {
            $project->update($request->validated());

            return response(__('messages.updated', ['resource' => 'projeto']));
        } catch (\Exception $error) {
            return response(__('messages.update_failed', ['resource' => 'projeto']), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();
            return response(__('messages.deleted', ['resource' => 'projeto']));
        } catch (\Exception $error) {
            return response(__('messages.delete_failed', ['resource' => 'projeto']), 500);
        }
    }
}
