<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
        // To access any menu we need to provide menu a permission.
        // So first need to create all permissions
        $this->call([
            DbControllerSeeder::class,

            // Do not comment this PermissionSeeder::class call.
            // It creates permissions for menus.
            // PermissionSeeder::class,

            // You can add or remove common admin menus from here.
            AdminMenuSeeder::class,

            // The RoleSeeder::class creates role
            // To add any new role edit this class
            RoleSeeder::class,

            // Do not remove SuperAdminSeeder::class call
            // It creates a SuperAdmin user
            // You can get AdminUser details from this class
            // Edit credentials if you want.
            SuperAdminSeeder::class,

            AdminUsersSeeder::class, // Comment this class call If don't want dummy admin users.
            // UserSeeder::class, // Comment this class call If don't want dummy frontend users.

            PageSeeder::class,

            SliderCategorySeeder::class,

            AssignUserAccessSeeder::class,

            MenuTypesSeeder::class,

            FrontMenuSeeder::class,

            MDepartmentSeeder::class,
            MOfficeSeeder::class,
            MDesignationSeeder::class,
            MCourseCategorySeeder::class,
            MCourseCategoryCourseSeeder::class,
            MAdditionalChargeReasonSeeder::class,

            OfficeOnboardingSeeder::class,
            CourseSeeder::class
        ]);
        Admin::whereNull('created_by')
            ->whereNull('created_by')
            ->update([
                'created_by' => 1,
                'updated_by' => 1,
            ]);
    }
}
