<?php

namespace App\Http\Resources;

use App\Enums\ProjectStatus;
use App\Models\Project;
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
        $projects = $this->projects();

        return [
            'last_opened' => array_filter(
                array_map(
                    fn ($id) => new ProjectResource(Project::find($id)),
                    $this->last_opened_projects
                ),
                fn ($val) => !is_null($val->resource)
            ),
            'last_updated' => $projects->latest('updated_at')->get()->slice(0, 3),
            'stats' => [
                'total' => $projects->get()->count(),
                'finished' => $projects->get()->filter(fn ($project) => $project->status === ProjectStatus::FINISHED->value)->count(),
                'in_progress' => $projects->get()->filter(fn ($project) => $project->status === ProjectStatus::IN_PROGRESS->value)->count(),
            ]
        ];
    }
}
