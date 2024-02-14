<?php

namespace App\Http\Middleware;

use App\Http\Services\RouteService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoutePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $route_service = new RouteService();
        $current_route = $route_service->getCurrentNamedRoute();
        // info('RoutePermission');
        $permission_name = $route_service->getPermissionNameByNamedRoute($current_route);
        $permissions = $route_service->getAllPermissionsNamedRoute();
        // dd($current_route, $permission_name, $permissions);
        // info('permission_name');
        // info($permission_name);
        // info('permissions');
        // info($permissions);
        if (!$current_route || !$permission_name || !$route_service->isUserAuthorisedToRoute(trim($permission_name), $permissions)) {
            if ($request->ajax()) {
                return response([
                    'error' => 'You are not authorised for the permission "' . $permission_name . '"'
                ]);
            } else {
                return response(view('admin.errors.unauthorized'));
            }
        }
        return $next($request);
    }
}
