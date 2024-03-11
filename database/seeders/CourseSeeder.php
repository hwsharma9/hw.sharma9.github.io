<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Course;
use App\Models\CourseTopic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tbl_courses')->truncate();
        DB::table('tbl_course_topics')->truncate();
        DB::table('tbl_course_media')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // dd('wait');
        $cms = Admin::where('fk_designation_id', 4)
            // ->where('id', 6)
            ->latest()
            ->take(15)
            ->get();
        if ($cms) {
            foreach ($cms as $cm) {
                $courses = $cm->assignCourses; //()->where('id', 21)->get();
                if ($courses) {
                    // print_r($cm->toArray());
                    // print_r($courses->toArray());
                    foreach ($courses as $course) {
                        Course::factory(rand(1, 2))
                            ->hasTopics(rand(5, 10))
                            ->createQuietly([
                                'fk_m_admin_course_id' => $course->id,
                            ]);
                    }
                }
            }
        }
    }
}
