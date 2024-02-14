<?php

namespace App\Policies\Admin;

use App\Models\Admin;
use App\Models\AssignUserAccess;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;

class AssignUserAccessPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, AssignUserAccess $assignUserAccess): Response
    {
        if ((session('role_name') == 'Super Admin')
            && in_array($assignUserAccess->id, [2, 3, 4, 5, 6])
        ) {
            return Response::deny('You are not allowed to update Access of this controller for your self.');
        } else {
            return Response::allow();
        }
    }
}
