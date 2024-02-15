<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return $user->can('view', $task->project()->first());
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return true; // This action is authorized via \App\Http\Requests\StoreTaskRequest
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->can('update', $task->project()->first());
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->can('update', $task->project()->first());
    }
}
