<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyProjectMemberRequest;
use App\Http\Requests\StoreProjectMemberRequest;
use App\Http\Requests\UpdateProjectMemberRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectMemberController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectMemberRequest $request, Project $project)
    {
        Gate::authorize('add-member', $project);

        $user = User::where('username', $request->member)
            ->orWhere('email', $request->member)
            ->first();

        if (!$user) return response('...', 404);

        $project->users()->attach($user->id);

        return response('...', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectMemberRequest $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyProjectMemberRequest $request, Project $project)
    {
        $user = User::where('username', $request->member)
            ->orWhere('email', $request->member)
            ->first();

        if (!$user) return response('...', 404);

        Gate::authorize('delete-member', [$project, $project->getMember($user->id)]);
    }
}
