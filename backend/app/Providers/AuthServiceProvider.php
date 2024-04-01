<?php

namespace App\Providers;

use App\Policies\ProjectMemberPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('add-member', [ProjectMemberPolicy::class, 'create']);
        Gate::define('update-member', [ProjectMemberPolicy::class, 'update']);
        Gate::define('delete-member', [ProjectMemberPolicy::class, 'delete']);
    }
}
