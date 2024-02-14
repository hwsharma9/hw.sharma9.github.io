<?php

namespace App\View\Composers;

use App\Http\Services\RouteService;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthRoleComposer
{
    protected $role;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        // dd(Auth::guard('admin')->user());
        // check if user is logged in
        if (Auth::guard('admin')->user()) {
            // check if user has role
            // and if role is valid
            // and if role is active
            // and if role is not deleted
            if (auth('admin')->user()->hasRole(session('role_name'))) {
                $route_service = new RouteService();
                // $this->role = $route_service->findRoleByName(session('role_name'));

                // Get first role by name with permissions
                $this->role = Role::where('name', session('role_name'))
                    ->with(['permissions'])
                    ->first();
            } else {
                // else get authenticated user
                $user = auth()->user();
                // get users all roles
                $roles = $user->roles()->get();
                // get first role with permissions
                $this->role = $roles[0]->load('permissions');
            }
        }
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'auth_role' => $this->role
        ]);
    }
}
