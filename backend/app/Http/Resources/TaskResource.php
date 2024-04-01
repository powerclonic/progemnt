<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class TaskResource extends JsonResource
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
            'status' => $this->status,
            'responsible' => $this->getResponsibleInfo($this->responsible),
            'deadline' => $this->deadline,
        ];
    }

    private function getResponsibleInfo(?int $id): ?array
    {
        if ($data = Cache::get("user_{$id}_responsible_data")) return $data;

        $user = User::find($id);
        if (!$user) return null;

        $data = [
            'id' => $id,
            'name' => $user->name
        ];

        Cache::put("user_{$id}_responsible_data", $data, now()->addDay());

        return $data;
    }
}
