<?php

namespace Database\Seeders;

use App\Http\Services\JsonService;
use App\Models\AdminMenu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tbl_acl_roles')->truncate();
        // DB::table('tbl_acl_role_has_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $roles = [
            [
                'id' => 1,
                'name' => 'Super Admin',
                'description' => 'Super Admin Permissions',
                'range' => '1,2,3,4,5,6,7,8,34,9,10,37,11,39,38,40,42,41,36,35,31,32,33,23,24,12,13,14,16,17,21,18',
                'used_for' => 'backend',
                'guard_name' => 'admin',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2024-01-09 06:12:26'
            ],
            [
                'id' => 2,
                'name' => 'System Admin',
                'description' => 'System Admin Permissions',
                'range' => '1,2,34,9,10,37,39,38,40,42,41,36',
                'used_for' => 'backend',
                'guard_name' => 'admin',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2023-11-30 15:45:27'
            ],
            [
                'id' => 3,
                'name' => 'Nodal Officer',
                'description' => 'Nodal Officer Permissions',
                'range' => '1,2,9,10,39,38,40,42,41,36',
                'used_for' => 'backend',
                'guard_name' => 'admin',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-11-06 07:38:55',
                'updated_at' => '2024-01-23 09:30:17'
            ],
            [
                'id' => 4,
                'name' => 'Content Manager',
                'description' => 'Content Manager Description',
                'range' => '1,2,39,43',
                'used_for' => 'backend',
                'guard_name' => 'admin',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-12-06 15:27:52',
                'updated_at' => '2024-01-06 09:46:43'
            ],
            [
                'id' => 5,
                'name' => 'User',
                'description' => 'User Description',
                'range' => NULL,
                'used_for' => 'frontend',
                'guard_name' => 'web',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => NULL,
                'created_at' => '2024-01-12 12:21:48',
                'updated_at' => '1970-01-01 00:00:00'
            ],
        ];
        Role::insert($roles);
        // $roles = Role::find(1);
        // $permissions = Permission::select(['id'])->get();
        // $roles->givePermissionTo($permissions->pluck('id')->all());
        // JsonService::createRolePermissionJson($roles->refresh());
    }
}
