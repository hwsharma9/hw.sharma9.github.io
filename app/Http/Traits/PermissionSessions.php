<?php

namespace App\Http\Traits;

use App\Models\Admin;
use App\Models\AdminRole;
use App\Models\DbControllerRoute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait PermissionSessions
{
    public static function setPermissionSessions()
    {
        // $auth_user = Admin::with(['roles'])->find(auth('admin')->id());
        // session(['user_roles' => $auth_user]);
        $auth_role = AdminRole::where(['fk_user_id' => auth('admin')->id(), 'is_default' => 1])->first();
        $role = auth('admin')->user()->roles()->where(['role_id' => $auth_role->fk_role_id])->first();
        // $db_route = DbControllerRoute::whereHas('permission')
        //     ->with(['permission'])
        //     ->whereIn('id', $role->permissions->pluck('fk_controller_route_id'))
        //     ->get();
        session(['role_name' => $role->name]);
        // session(['db_route' => $db_route]);
    }
}
