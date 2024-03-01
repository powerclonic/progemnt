<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectMemberPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Project $project): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project, object $member): bool
    {
        info($member->permission);

        return true;
    }
}
