<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tbl_acl_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $permissions = [
            [
                'id' => 1,
                'name' => 'Admins List',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 7,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 2,
                'name' => 'Admin Create',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 8,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 3,
                'name' => 'Admin Store',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 9,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 4,
                'name' => 'Admin Edit',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 10,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 5,
                'name' => 'Admin Update',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 11,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 6,
                'name' => 'Users List',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 51,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 7,
                'name' => 'User Create',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 52,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 8,
                'name' => 'User Store',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 53,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 9,
                'name' => 'User Edit',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 54,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 10,
                'name' => 'User Update',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 55,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 11,
                'name' => 'Admin Menus List',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 14,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 12,
                'name' => 'Pages List',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 33,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 13,
                'name' => 'Page Create',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 34,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 14,
                'name' => 'Page Store',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 35,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 15,
                'name' => 'Page Edit',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 36,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 16,
                'name' => 'Page Update',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 37,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 17,
                'name' => 'Roles List',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 39,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 18,
                'name' => 'Role Create',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 40,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 19,
                'name' => 'Role Store',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 41,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 20,
                'name' => 'Role Edit',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 42,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 21,
                'name' => 'Role Update',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 43,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 22,
                'name' => 'Access List',
                'guard_name' => 'admin',
                'fk_controller_route_id' => null,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 23,
                'name' => 'Assign User Access',
                'guard_name' => 'admin',
                'fk_controller_route_id' => null,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 24,
                'name' => 'Permissions List',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 1,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 25,
                'name' => 'Permission Create',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 2,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 26,
                'name' => 'Permission Edit',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 4,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 27,
                'name' => 'Permission Store',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 3,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 28,
                'name' => 'Permission Update',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 5,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 29,
                'name' => 'Social Links',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 45,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 30,
                'name' => 'Dashboard',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 26,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 31,
                'name' => 'Controllers List',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 57,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 32,
                'name' => 'Controller Create',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 58,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 33,
                'name' => 'Controller Store',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 59,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 34,
                'name' => 'Controller Edit',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 60,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 35,
                'name' => 'Controller Update',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 61,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 36,
                'name' => 'Media List',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 27,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 37,
                'name' => 'Media Create',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 28,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 38,
                'name' => 'Media Store',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 29,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 39,
                'name' => 'Media Edit',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 30,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 40,
                'name' => 'Media Update',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 31,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 41,
                'name' => 'Admin Menus Store',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 15,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 42,
                'name' => 'Admin Menus Update',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 17,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 43,
                'name' => 'Front Menus Module List',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 20,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 44,
                'name' => 'Front Menus Module Create',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 21,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 45,
                'name' => 'Front Menus Module Store',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 22,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 46,
                'name' => 'Front Menus Module Edit',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 23,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 47,
                'name' => 'Front Menus Module Update',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 24,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 48,
                'name' => 'Delete media',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 32,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 49,
                'name' => 'Social Urls List',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 45,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 50,
                'name' => 'Social Urls Create',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 46,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 51,
                'name' => 'Social Urls Store',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 47,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 52,
                'name' => 'Social Urls Edit',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 48,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 53,
                'name' => 'Social Urls Update',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 49,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 54,
                'name' => 'Delete Social Url',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 50,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 55,
                'name' => 'Update menu order',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 13,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 56,
                'name' => 'Delete Controllers',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 62,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 57,
                'name' => 'Delete Controllers Route',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 63,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 58,
                'name' => 'Sliders List',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 64,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 59,
                'name' => 'Sliders Create',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 65,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 60,
                'name' => 'Sliders Store',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 66,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 61,
                'name' => 'Sliders Edit',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 67,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 62,
                'name' => 'Sliders Update',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 68,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 63,
                'name' => 'Delete Sliders',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 69,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 64,
                'name' => 'Delete Admin Menus',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 19,
                'deleted_at' => null,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-06 07:38:55'
            ],
            [
                'id' => 65,
                'name' => 'Assign User Access index',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 70,
                'deleted_at' => null,
                'created_at' => '2023-11-06 18:11:01',
                'updated_at' => '2023-11-06 18:11:01'
            ],
            [
                'id' => 66,
                'name' => 'Assign User Access create',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 71,
                'deleted_at' => null,
                'created_at' => '2023-11-06 18:11:01',
                'updated_at' => '2023-11-06 18:11:01'
            ],
            [
                'id' => 67,
                'name' => 'Assign User Access store',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 72,
                'deleted_at' => null,
                'created_at' => '2023-11-06 18:11:01',
                'updated_at' => '2023-11-06 18:11:01'
            ],
            [
                'id' => 68,
                'name' => 'Assign User Access edit',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 73,
                'deleted_at' => null,
                'created_at' => '2023-11-06 18:11:02',
                'updated_at' => '2023-11-06 18:11:02'
            ],
            [
                'id' => 69,
                'name' => 'Assign User Access update',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 74,
                'deleted_at' => null,
                'created_at' => '2023-11-06 18:11:02',
                'updated_at' => '2023-11-06 18:11:02'
            ],
            [
                'id' => 70,
                'name' => 'Assign User Access destroy',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 75,
                'deleted_at' => null,
                'created_at' => '2023-11-06 18:11:02',
                'updated_at' => '2023-11-06 18:11:02'
            ],
            [
                'id' => 70,
                'name' => 'Page Manager index',
                'guard_name' => 'admin',
                'fk_controller_route_id' => 75,
                'deleted_at' => null,
                'created_at' => '2023-11-06 18:11:02',
                'updated_at' => '2023-11-06 18:11:02'
            ],
        ];
        Permission::insert($permissions);
    }
}
