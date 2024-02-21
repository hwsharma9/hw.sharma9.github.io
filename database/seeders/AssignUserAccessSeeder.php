<?php

namespace Database\Seeders;

use App\Http\Services\JsonService;
use App\Models\AssignUserAccess;
use App\Models\DbController;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignUserAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tableNames = config('dbtables.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/dbtables.php not loaded. Run [php artisan config:clear] and try again.');
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table($tableNames['assign_user_accesses'])->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $super_admin_role = Role::find(1);
        $sa_controllers = DbController::with(['permissions'])->where('resides_at', 'manage')->get();
        $permissions = $sa_controllers->pluck('permissions.*.id')->collapse()->all(); //Permission::select(['id'])->get();
        foreach ($sa_controllers as $sa_controller) {
            AssignUserAccess::insert([
                'fk_role_id' => $super_admin_role->id,
                'fk_controller_id' => $sa_controller->id,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        }

        $super_admin_role->givePermissionTo($permissions);
        JsonService::createRolePermissionJson($super_admin_role->refresh());

        // provide permission to System Admin
        $system_admin = Role::backend()->where('id', '=', 2)->first();
        $system_admin_controllers = DbController::with(['permissions'])->find([1, 7, 17, 20, 21, 22, 23, 24]);
        $system_admin_permissions = $system_admin_controllers->pluck('permissions.*.id')->collapse()->all(); //Permission::select(['id'])->where('id', 1)->get();

        foreach ($system_admin_controllers as $system_admin_controller) {
            AssignUserAccess::insert([
                'fk_role_id' => $system_admin->id,
                'fk_controller_id' => $system_admin_controller->id,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        }
        $system_admin->givePermissionTo($system_admin_permissions);
        JsonService::createRolePermissionJson($system_admin->refresh());

        // provide permission to Nodal Officer
        $nodal_officer = Role::backend()->where('id', '=', 3)->first();
        $nodal_controllers = DbController::with(['permissions'])->find([1, 7, 19, 21, 22, 23, 24, 26]);
        $nodal_permissions = $nodal_controllers->pluck('permissions.*.id')->collapse()->all(); //Permission::select(['id'])->where('id', 1)->get();

        foreach ($nodal_controllers as $nodal_controller) {
            AssignUserAccess::insert([
                'fk_role_id' => $nodal_officer->id,
                'fk_controller_id' => $nodal_controller->id,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        }
        $nodal_officer->givePermissionTo($nodal_permissions);
        JsonService::createRolePermissionJson($nodal_officer->refresh());


        // provide permission to Content Manager
        $content_manager = Role::backend()->where('id', '=', 4)->first();
        $content_manager_controllers = DbController::with(['permissions'])->find([1, 19, 25, 26]);
        $content_manager_permissions = $content_manager_controllers->pluck('permissions.*.id')->collapse()->all(); //Permission::select(['id'])->where('id', 1)->get();

        foreach ($content_manager_controllers as $content_manager_controller) {
            AssignUserAccess::insert([
                'fk_role_id' => $content_manager->id,
                'fk_controller_id' => $content_manager_controller->id,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        }
        $content_manager->givePermissionTo($content_manager_permissions);
        JsonService::createRolePermissionJson($content_manager->refresh());

        AssignUserAccess::whereNull('created_by')
            ->whereNull('updated_by')
            ->update([
                'created_by' => 1,
                'updated_by' => 1
            ]);
    }
}
