<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline,
            'users' => $this->users()
                ->get(['users.id', 'name'])
                ->each(function ($user) {
                    $user->permission = (int) $user->pivot->permission;
                    unset($user->pivot);
                }),
            'tasks' => TaskResource::collection($this->tasks()->get()),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
