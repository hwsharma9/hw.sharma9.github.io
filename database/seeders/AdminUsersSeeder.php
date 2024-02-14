<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AdminRole;
use App\Models\MAdminCourse;
use App\Models\OfficeOnboarding;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $roles = Role::select('name')
        //     ->whereNotIn('name', ['Super Admin', 'User'])
        //     ->pluck('name')
        //     ->all();
        // for ($i = 0; $i < 100000; $i++) {
        //     shuffle($roles);
        //     $admin = Admin::factory(1)->create([
        //         'designation' => $roles[0]
        //     ]);
        // }
        // $admins = Admin::whereNotIn('designation', ['Super Admin', 'User'])->get();
        // foreach ($admins as $key => $admin) {
        //     $admin->assignRole($admin->designation);
        // }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tbl_admins')->where('id', '>', 1)->delete();
        DB::table('tbl_admin_user_details')->where('id', '>', 1)->delete();
        DB::table('tbl_admin_roles')->where('id', '>', 1)->delete();
        DB::table('tbl_acl_model_has_roles')->where('model_id', '!=', 1)->where('role_id', '!=', 1)->delete();
        DB::table('tbl_office_onboardings')->truncate();
        DB::table('m_admin_courses')->truncate();
        DB::statement('ALTER TABLE tbl_admins AUTO_INCREMENT=2');
        DB::statement('ALTER TABLE tbl_admin_user_details AUTO_INCREMENT=2');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Admin::withoutEvents(function () {
            $system_admin = $this->createAdmin([
                'fk_designation_id' => 2, // System Admin
                'email' => 'system.admin@mp.gov.in',
                'created_by' => 1,
            ]);

            $office_onboarding = OfficeOnboarding::factory(1)->create([
                'nodal_name' => 'Vinay Panday',
                'nodal_contact_number' => '9876543220',
                'nodal_email' => 'nodal_officer@mp.gov.in',
                'office_address' => 'Bhopal',
                'created_by' => $system_admin->id,
                'status' => 1
            ]);
            $nodal_officer = $this->createAdmin([
                'fk_designation_id' => 3, // Nodal Officer
                'email' => 'nodal.officer@mp.gov.in',
                'created_by' => $system_admin->id,
            ], [
                'fk_office_onboarding_id' => $office_onboarding->first()->id,
            ]);

            MAdminCourse::create([
                'fk_admin_id' => $nodal_officer->id,
                'fk_course_category_id' => 1,
                'fk_course_category_courses_id' => 1
            ]);

            $content_manager = $this->createAdmin([
                'fk_designation_id' => 4, // Content Manager
                'email' => 'content.manager@mp.gov.in',
                'created_by' => $nodal_officer->id,
            ], [
                'fk_office_onboarding_id' => $office_onboarding->first()->id,
            ]);
        });
    }

    public function createAdmin($other_details, $detail = [])
    {
        $constent_details = [
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
            'password_changed_at' => now(),
            'is_profile_updated' => true,
            'created_at' => now(),
            'password' => 'password'
        ];
        $admin_details = array_merge($constent_details, $other_details);
        $admin = Admin::factory(1)->create($admin_details);
        $this->assignRoleTOAdmin($admin->first(), $other_details['fk_designation_id'], $other_details['created_by']);

        $constent_detail = [
            'created_by' => $other_details['created_by'],
            'created_at' => now(),
        ];
        $admin_detail = array_merge($constent_detail, $detail);
        $admin->first()->detail()->create($admin_detail);
        return $admin->first();
    }

    public function assignRoleTOAdmin(Admin $admin, $role_id, $created_by)
    {
        $role = AdminRole::create([
            'fk_user_id' => $admin->id,
            'fk_role_id' => $role_id,
            'is_default' => 1,
            'status' => 1,
            'created_by' => $created_by,
            'created_at' => now(),
        ]);
        if ($role) {
            $admin->assignRole(intval($role_id));
        }
    }
}
