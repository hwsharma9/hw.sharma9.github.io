<?php

namespace App\Policies\Admin;

use App\Models\Role;
use App\Models\Admin;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;

class RolePolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Role $role): Response
    {
        $range = request()->range;
        // If user is super admin and trying to remove access of any acl menus for his self.
        if ((session('role_name') == 'Super Admin' && $role->name == 'Super Admin')
            && (!in_array(3, $range) // ACL Menu id
                || !in_array(4, $range) // Access List Menu id
                || !in_array(5, $range) // Admin Menu Menu id
                || !in_array(6, $range) // Role Management Menu id
                || !in_array(7, $range) // Assign User Access Menu id
                || !in_array(8, $range) // Permission Menu id
            )
        ) {
            return Response::deny('You are not allowed to remove access of any acl menus for your self.');
        } else {
            return Response::allow();
        }
    }
}
