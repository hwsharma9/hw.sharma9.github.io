<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Gate;

class GateAllow
{
    /**
     * Check the permission of named route by Gate
     *
     * @param  $action
     * @return boolean
     */
    public static function for($named_route)
    {
        return Gate::allows('check-auth', $named_route);
    }

    public static function forAll($actions)
    {
        $permissions = [];
        if ($actions) {
            foreach ($actions as $action => $named_route) {
                $permissions[$action] = self::for($named_route);
            }
        }
        return $permissions;
    }
}
