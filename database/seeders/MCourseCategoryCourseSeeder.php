<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MCourseCategoryCourse;

class MCourseCategoryCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('m_course_category_courses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $m_course_category_courses = [
            [
                'id' => 1,
                'fk_course_category_id' => 1,
                'course_name_hi' => 'कोर पीएचपी',
                'course_name_en' => 'Core PHP',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 2,
                'fk_course_category_id' => 1,
                'course_name_hi' => 'एडवांस पीएचपी',
                'course_name_en' => 'Advance PHP',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 3,
                'fk_course_category_id' => 2,
                'course_name_hi' => 'कोर जे एस',
                'course_name_en' => 'Core JS',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 4,
                'fk_course_category_id' => 2,
                'course_name_hi' => 'एडवांस जे एस',
                'course_name_en' => 'Advance JS',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 5,
                'fk_course_category_id' => 3,
                'course_name_hi' => 'कोर जावा',
                'course_name_en' => 'Core JAVA',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 6,
                'fk_course_category_id' => 3,
                'course_name_hi' => 'एडवांस जावा',
                'course_name_en' => 'Advance JAVA',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 7,
                'fk_course_category_id' => 4,
                'course_name_hi' => 'कोर पाइथन',
                'course_name_en' => 'Core PYTHON',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 8,
                'fk_course_category_id' => 4,
                'course_name_hi' => 'एडवांस पाइथन',
                'course_name_en' => 'Advance PYTHON',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now()
            ],
        ];

        MCourseCategoryCourse::insert($m_course_category_courses);
    }
}
