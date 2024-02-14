<?php

namespace App\Http\Middleware;

use App\Http\Services\RouteService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsPasswordChange
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
        $auth_user = auth('admin')->user();
        if (
            is_null($auth_user->password_changed_at)
            && $route_service->getCurrentNamedRoute() != "profile.change-password"
        ) {
            return redirect()->route('manage.profile.change-password')
                ->with('warning', 'Please change the password first!');
        }
        // $roles = $auth_user->load('admin_roles.role');
        return $next($request);
    }
}
