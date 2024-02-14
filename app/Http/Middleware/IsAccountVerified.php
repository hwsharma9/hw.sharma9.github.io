<?php

namespace App\Http\Middleware;

use App\Http\Services\RouteService;
use Closure;
use Illuminate\Http\Request;

class IsAccountVerified
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
        // Check if admin users email is verified
        // if not verified
        if (
            is_null(auth('admin')->user()->email_verified_at)
            && !in_array($route_service->getCurrentNamedRoute(), ["profile", 'profile.verified-otp'])
        ) {
            // redirect user to profile page to verify email
            return redirect()
                ->to(route('manage.profile', encrypt(auth('admin')->id())) . '#otp_verification')
                ->with('otp_verification', 'Please Verify your Email!');
        }
        // Check if admin users mobile is verified
        // if not verified
        if (
            is_null(auth('admin')->user()->mobile_verified_at)
            && !in_array($route_service->getCurrentNamedRoute(), ["profile", 'profile.verified-otp'])
        ) {
            // redirect user to profile page to verify mobile
            return redirect()
                ->to(route('manage.profile', encrypt(auth('admin')->id())) . '#otp_verification')
                ->with('otp_verification', 'Please Verify your Mobile!');
        }
        // Check if admin users has filled his profile details or not
        // if not filled
        if (
            $request->isMethod('get')
            && auth('admin')->user()->is_profile_updated == 0
            && $route_service->getCurrentNamedRoute() != "profile"
        ) {
            // redirect user to profile page to fill the profile details
            return redirect()->route('manage.profile', encrypt(auth('admin')->id()))
                ->with('update_profile', 'Please update your profile first!');
        }

        $admin_roles = auth('admin')->user()->admin_roles()->where('status', 1)->get();
        $role_names = $admin_roles->pluck('role.name')->all();
        if (!in_array(session('role_name'), $role_names)) {
            if (count($role_names)) {
                request()->session()->forget('role_name');
                request()->session()->put('role_name', $role_names[count($role_names) - 1]);
                return redirect()->route('manage.home');
            }
        }
        return $next($request);
    }
}
