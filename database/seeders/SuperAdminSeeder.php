<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AdminUserDetail;
use App\Models\AssignUserAccess;
use App\Models\DbController;
use App\Models\DbControllerRoute;
use App\Models\Role;
use App\Models\User;
use App\Models\AdminRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
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
        DB::table($tableNames['admins'])->truncate();
        DB::table('tbl_acl_model_has_roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $admin_id = Admin::insertGetId([
            'username' => 'superadmin',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'mobile' => '1234567890',
            'email' => 'superadmin@mp.gov.in',
            'fk_designation_id' => 1,
            'status' => 1,
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
            // To create new password just run below commands
            // php artisan tinker
            // Hash::make('newpassword'); Copy the Sha1 String and paste here
            // Easy right? :)
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // Password will have to be changed if password_changed_at = NULL
            'password_changed_at' => now(),
            'is_profile_updated' => true,
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $admin = Admin::find($admin_id);
        AdminUserDetail::insert([
            'fk_admin_id' => $admin->id,
            'created_by' => $admin->id,
            'created_at' => now(),
        ]);
        $role = Role::find(1);
        AdminRole::insert([
            'fk_user_id' => $admin->id,
            'fk_role_id' => $role->id,
            'status' => 1,
            'is_default' => 1,
            'created_by' => $admin->id,
            'created_at' => now(),
        ]);
        if (!$admin->hasRole($role->id)) {
            $admin->assignRole($role->id);
        }
    }
}
