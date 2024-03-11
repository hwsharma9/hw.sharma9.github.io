<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AdminRole;
use App\Models\MAdminCourse;
use App\Models\MCourseCategory;
use App\Models\MDepartment;
use App\Models\OfficeOnboarding;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficeOnboardingSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::table('m_course_categories')->truncate();
        // DB::table('m_course_category_courses')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $departments = MDepartment::with(['offices'])->get();
        $office_onboardings = OfficeOnboarding::select(['id', 'fk_department_id', 'fk_office_id'])->get();
        // print_r($office_onboardings);
        foreach ($departments as $department) {
            MCourseCategory::factory(2)
                ->hasCourses(2)
                ->createQuietly([
                    'fk_department_id' => $department->id,
                ]);
            if ($department->offices) {
                foreach ($department->offices as $office) {
                    // echo $department->id . ' => ' . $office->id . '\n';
                    if ($office_onboardings->where('fk_department_id', $department->id)->where('fk_office_id', $office->id)->count() == 0) {
                        // print_r($department->categories->toArray());
                        $office_onboarding = OfficeOnboarding::where([
                            'fk_department_id' => $department->id,
                            'fk_office_id' => $office->id,
                        ]);
                        if ($office_onboarding->count() > 0) {
                            $office_onboarding = $office_onboarding->first();
                        } else {
                            $office_onboarding = OfficeOnboarding::factory(1)
                                ->createQuietly([
                                    'fk_department_id' => $department->id,
                                    'fk_office_id' => $office->id,
                                    'nodal_contact_number' => rand(1111111111, 9999999999),
                                    'nodal_email' => $this->getInitialsAttribute($office->title_en) . '_' . rand(10000, 99999) . '_no@mp.gov.in',
                                    'office_address' => 'Bhopal',
                                    'created_by' => 2,
                                    'status' => 1
                                ]);
                        }

                        $nodal_officer = $this->createAdmin([
                            'fk_designation_id' => 3, // Nodal Officer
                            'email' => $this->getInitialsAttribute($office->title_en) . '_' . rand(10000, 99999) . '.no@mp.gov.in',
                            'created_by' => 2,
                        ], [
                            'fk_office_onboarding_id' => $office_onboarding->first()->id,
                        ]);

                        $content_manager = $this->createAdmin([
                            'fk_designation_id' => 4, // Content Manager
                            'email' => $this->getInitialsAttribute($office->title_en) . '_' . rand(10000, 99999) . '.cm@mp.gov.in',
                            'created_by' => $nodal_officer->id,
                        ], [
                            'fk_office_onboarding_id' => $office_onboarding->first()->id,
                        ]);
                        if ($department->categories) {
                            foreach ($department->categories as $category) {
                                if ($category->courses) {
                                    foreach ($category->courses as $course) {
                                        $mcourse = new MAdminCourse;
                                        $mcourse->fill([
                                            'fk_admin_id' => $content_manager->id,
                                            'fk_course_category_id' => $course->fk_course_category_id,
                                            'fk_course_category_courses_id' => $course->id,
                                            'status' => 1,
                                            'created_by' => $nodal_officer->id,
                                        ]);
                                        $mcourse->saveQuietly();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
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
        $admin = Admin::factory(1)->createQuietly($admin_details);
        $this->assignRoleTOAdmin($admin->first(), $other_details['fk_designation_id'], $other_details['created_by']);

        $constent_detail = [
            'created_by' => $other_details['created_by'],
            'created_at' => now(),
        ];
        $admin_detail = array_merge($constent_detail, $detail);
        $admin->first()->detail()->createQuietly($admin_detail);
        return $admin->first();
    }

    public function assignRoleTOAdmin(Admin $admin, $role_id, $created_by)
    {
        $role = new AdminRole;
        $role->fill([
            'fk_user_id' => $admin->id,
            'fk_role_id' => $role_id,
            'is_default' => 1,
            'status' => 1,
            'created_by' => $created_by,
            'created_at' => now(),
        ]);
        $role = $role->saveQuietly();
        if ($role) {
            $admin->assignRole(intval($role_id));
        }
    }

    public function getInitialsAttribute($name)
    {
        $name_array = explode(' ', trim($name));

        $firstWord = $name_array[0];
        $lastWord = $name_array[count($name_array) - 1];

        return $firstWord[0] . "" . $lastWord[0];
    }
}
