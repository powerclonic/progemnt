<?php

namespace App\Http\Resources;

use App\Enums\ProjectStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\Project> $projects */
        $projects = $this->projects()->get();

        return [
            'last_opened' => '', // TODO: Create user last opened projects attr
            'last_updated' => $projects->sortBy('updated_at')->slice(0, 3),
            'stats' => [
                'total' => $projects->count(),
                'finished' => $projects->filter(fn ($project) => $project->status === ProjectStatus::FINISHED->value)->count(), // TODO
                'in_progress' => $projects->filter(fn ($project) => $project->status === ProjectStatus::IN_PROGRESS->value)->count(), // TODO
            ]
        ];
    }
}
