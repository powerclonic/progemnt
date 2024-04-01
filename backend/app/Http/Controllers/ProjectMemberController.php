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

        if (!$user) return response(__('messages.not_found', ['resource' => 'usuário']), 404);

        if ($project->users()->find($user->id)) return response(__('messages.user_already_in_project'), 409);

        try {
            $project->users()->attach($user->id);
        } catch (\Exception $error) {
            return response(__('messages.create_failed', ['resource' => 'membro']));
        }

        return response(__('messages.created', ['resource' => 'membro']), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectMemberRequest $request, Project $project)
    {
        $member = $project->getMember($request->member);

        if (!$member) return response(__('messages.not_found', ['resource' => 'membro']), 404);

        Gate::authorize('update-member', [$project, $member, $request->permission]);
        try {
            $project->users()->updateExistingPivot($member->id, ['permission' => $request->permission]);
        } catch (\Exception $error) {
            return response(__('messages.update_failed', ['resource' => 'membro']));
        }

        return response(__('messages.updated', ['resource' => 'membro']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyProjectMemberRequest $request, Project $project)
    {
        $member = $project->getMember($request->member);

        if (!$member) return response(__('messages.not_found', ['resource' => 'membro']), 404);

        Gate::authorize('delete-member', [$project, $member]);

        try {
            $project->users()->detach($member->id);
        } catch (\Exception $error) {
            return response(__('messages.delete_failed', ['resource' => 'membro']));
        }

        return response(__('messages.deleted', ['resource' => 'membro']));
    }
}
