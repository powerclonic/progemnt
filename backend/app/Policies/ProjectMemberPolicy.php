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
        $userLevel = $project->getMember($user->id)?->pivot->permission;

        if (!$userLevel || $userLevel <= 2) return false;

        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project, User $member, int $newLevel): bool
    {
        $memberLevel = $member->pivot->permission;
        $userLevel   = $project->getMember($user->id)?->pivot->permission;

        if (!$memberLevel || !$userLevel) return false; // If the user isn't member of the project

        if ($newLevel >= 4) return false;

        if ($memberLevel >= 4) return false; // Cannot update the owner

        if ($userLevel <= 2) return false; // User needs to be at least admin (3)

        if ($userLevel === $memberLevel) return false; // Admins cannot remove other admins

        if ($userLevel <= 3 && $newLevel >= 3) return false;

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project, User $member): bool
    {
        $memberLevel = $member->pivot->permission;
        $userLevel   = $project->getMember($user->id)?->pivot->permission;

        if (!$memberLevel || !$userLevel) return false; // If the user isn't member of the project

        if ($memberLevel >= 4) return false; // Cannot remove the owner

        if ($userLevel <= 2) return false; // User needs to be at least admin (3)

        if ($userLevel === $memberLevel) return false; // Admins cannot remove other admins

        return true;
    }
}
