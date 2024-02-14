<?php

namespace App\Http\Services;

use App\Models\DbControllerRoute;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;

class JsonService
{
    /**
     * Create the json file and put the data in json format
     *
     * @param  $file_name
     * @param  $data
     * @return void
     */
    public static function createJsonFile($file_name, $data)
    {
        Storage::disk('public')->put(
            'permissions/' . $file_name . '.json',
            json_encode($data)
        );
    }

    /**
     * Create the json file for admin sidebar menues
     *
     * @return void
     */
    public static function createAdminSidebarMenuJson()
    {
        $db_controller_routes = DbControllerRoute::with([
            'dbController' => function ($query) {
                $query->select([
                    'id',
                    'title',
                    'resides_at',
                    'controller_name',
                    'status'
                ]);
            }
        ])
            ->select([
                'id',
                'route',
                'named_route',
                'method',
                'function_name',
                'fk_controller_id',
                'status'
            ])
            ->get();
        cache()->forget('admin_menu');
        self::createJsonFile('admin_menu', $db_controller_routes);
    }

    /**
     * Create the json file for a particular role with there permissions
     *
     * @param $role
     * @return void
     */
    public static function createRolePermissionJson($role)
    {
        $role_permission = DbControllerRoute::query()
            ->select(['id', 'route', 'named_route', 'method', 'function_name', 'fk_controller_id', 'status'])
            ->whereHas('permission')
            ->whereHas('assignUserAccess', function ($query) use ($role) {
                $query->where('fk_role_id', $role->id);
            })
            ->with(['permission' => function ($query) {
                $query->select(['id', 'name', 'guard_name', 'fk_controller_route_id']);
            }, 'assignUserAccess' => function ($query) use ($role) {
                $query->select(['id', 'fk_role_id', 'fk_controller_id', 'status'])->where('fk_role_id', $role->id);
            }])
            ->whereIn('id', $role->permissions->pluck('fk_controller_route_id'))
            ->get();
        // dd($role_permission->toArray());
        self::createJsonFile($role->name, $role_permission);
    }

    /**
     * Read the json data from json file and convert the json content to array
     *
     * @return array
     */
    public static function getJson($file_name)
    {
        try {
            // Read the json file and convert the json content to array
            $path = Storage::disk('public')->get(
                'permissions/' . $file_name . '.json'
            );
            return json_decode($path);
        } catch (\Throwable $th) {
            // if the json file is not found
            if ($th->getMessage()) {
                info($th->getMessage());
                // then get the role
                $role = Role::where('name', $file_name)->first();
                // if the role is not found
                if (!$role) {
                    // then create the json file for admin sidebar menus
                    self::createAdminSidebarMenuJson();
                } else {
                    // else create the json file for a particular role with there permission
                    self::createRolePermissionJson($role);
                }
                // then read the json file
                return self::getJson($file_name);
            }
        }
    }
}
