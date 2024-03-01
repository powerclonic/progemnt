<?php

namespace App\Policies;

use App\Enums\ProjectVisibility;
use App\Enums\UserPermission;
use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        [
            $userLevel,
            $projectLevel
        ] = $this->getLevels($user, $project);

        if ($projectLevel >= ProjectVisibility::PUBLIC->value || $userLevel === UserPermission::OWNER->value) {
            return true;
        }

        if ($projectLevel === ProjectVisibility::PRIVATE->value) {
            return false;
        }

        return $projectLevel === ProjectVisibility::MEMBERS->value && $userLevel >= UserPermission::SPECTATOR->value;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        [$userLevel] = $this->getLevels($user, $project);

        return $userLevel >= UserPermission::MEMBER->value;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        [$userLevel] = $this->getLevels($user, $project);

        return $userLevel >= UserPermission::OWNER->value;
    }

    /**
     * @return array<int>
     */
    private function getLevels(User $user, Project $project): array
    {
        return [
            (int) $project->users()->withPivot('permission')->find($user->id)?->pivot->permission, // Casts null to 0
            $project->visibility->value
        ];
    }
}
