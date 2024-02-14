<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Http\Services\RouteService;
use App\Models\AssignUserAccess;
use App\Models\Role;
use App\Policies\Admin\AssignUserAccessPolicy;
use App\Policies\Admin\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        AssignUserAccess::class => AssignUserAccessPolicy::class,
        Role::class => RolePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('check-auth', function ($user, $route = '') {
            $route_service = new RouteService();
            $current_route = $route_service->getCurrentNamedRoute($route);
            $permission_name = $route_service->getPermissionNameByNamedRoute($current_route);
            $permissions = $route_service->getAllPermissionsNamedRoute();
            if (!$current_route || !$permission_name || !$route_service->isUserAuthorisedToRoute(trim($permission_name), $permissions)) {
                return false;
            } else {
                return true;
            }
        });
    }
}
