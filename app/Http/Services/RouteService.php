<?php

namespace App\Http\Services;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class RouteService
{
    // public function __construct()
    // {
    //     dd(session('db_route'));
    // }
    public function isUserAuthorisedToRoute($current_route, $permissions)
    {
        return in_array($current_route, $permissions);
    }

    public function getCurrentNamedRoute($route = '')
    {
        if (empty($route)) {
            $current_route = Route::currentRouteName();
        } else {
            $current_route = $route;
        }
        return str_replace('manage.', '', $current_route);
    }

    public function findPermissionByNamedRoute($named_route)
    {
        $db_route = collect(JsonService::getJson(trim($this->getDefaultRole())));
        // info('db_route');
        // info($this->getDefaultRole());
        // info($db_route);
        $is_found = $db_route->where('named_route', $named_route)->where('assign_user_access.status', 1);
        // info('is_found');
        // info($is_found);
        if ($is_found->count() > 0) {
            return $is_found->first();
        } else {
            info('named_route => ' . $named_route . ' found by query!');
            return null;
            // return DatabaseRoute::whereHas('permission')
            //     ->with(['permission'])
            //     ->where('named_route', $named_route)
            //     ->first();
        }
    }

    public function getPermissionNameByNamedRoute($named_route)
    {
        $route = $this->findPermissionByNamedRoute($named_route);
        return isset($route->permission) ? $route->permission->name : null;
    }

    public function getDefaultRole()
    {
        return session('role_name');
    }

    public function getRoleByName($role_name = '')
    {
        if (empty($role_name)) {
            $role_name = $this->getDefaultRole();
        }
        if (!$role_name) {
            return null;
        }
        return $this->findRoleByName($role_name);
    }

    public function findRoleByName($role_name)
    {
        // if ($is_role->count() > 0) {
        //     return $is_role->first();
        // } else {
        $all_roles = auth('admin')->user(); //session('user_roles');
        if ($all_roles->roles->count() > 0) {
            // info('role_name => ' . $role_name . ' find from session!');
            $role = $all_roles->roles->where('name', $role_name)->first();
            // return $role;
        } else {
            // info('role_name => ' . $role_name . ' find from DB!');
            $role = Role::findByName($role_name);
        }
        $role->permissions = collect(JsonService::getJson(trim($role_name)));
        // $role->permissions = $permissions; //->where('assign_user_access.status', 1);
        return $role;
        // }
    }

    public function getAllPermissionsNamedRoute()
    {
        $role = $this->getRoleByName();
        if (!$role) {
            return null;
        }
        if ($role->permissions) {
            $permissions = $role->permissions->pluck('permission');
        } else {
            // info('run permissions query!');
            $permissions = Permission::whereHas('databaseRoute')
                ->with(['databaseRoute'])
                ->whereIn('id', $role->permissions->pluck('id')->all())
                ->get();
        }

        // $named_routes = $permissions->pluck('databaseRoute.named_route')
        //     ->all();

        // $named_routes[] = 'home';
        return $permissions->pluck('name')->all();
    }

    public function getControllerIdByRouteName()
    {
        $named_route = $this->getCurrentNamedRoute();
        $db_route = collect(JsonService::getJson(trim($this->getDefaultRole())));
        $is_found = $db_route->where('named_route', $named_route)->where('assign_user_access.status', 1);
        return $is_found->first();
    }
}
