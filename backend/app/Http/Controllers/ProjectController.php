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
            return response(__('messages.project.created'));
        } catch (\Exception $error) {
            return __('messages.project.create_failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        try {
            $project->update($request->validated());

            return response(__('messages.project.updated'));
        } catch (\Exception $error) {
            return __('messages.project.update_failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();
            return response(__('messages.project.deleted'));
        } catch (\Exception $error) {
            return __('messages.project.delete_failed');
        }
    }
}
