<?php

namespace App\Models;

use App\Enums\ProjectVisibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'visibility',
        'deadline'
    ];

    protected $casts = [
        'deadline' => 'date',
        'visibility' => ProjectVisibility::class
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('permission');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function getMember(int $id)
    {
        return $this->users()->find($id);
    }
}
