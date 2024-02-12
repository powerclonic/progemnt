<?php

namespace App\Models;

use App\Enums\ProjectVisibility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}
