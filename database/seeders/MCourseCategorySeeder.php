<?php

namespace Database\Seeders;

use App\Models\MCourseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MCourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('m_course_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $m_course_categories = [
            [
                'id' => 1,
                'fk_department_id' => 53,
                'category_name_hi' => 'पीएचपी',
                'category_name_en' => 'PHP',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 2,
                'fk_department_id' => 53,
                'category_name_hi' => 'जे एस',
                'category_name_en' => 'JS',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 3,
                'fk_department_id' => 54,
                'category_name_hi' => 'जावा',
                'category_name_en' => 'JAVA',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now()
            ],
            [
                'id' => 4,
                'fk_department_id' => 54,
                'category_name_hi' => 'पाइथन',
                'category_name_en' => 'PYTHON',
                'status' => 1,
                'created_by' => 1,
                'created_at' => now()
            ],
        ];

        MCourseCategory::insert($m_course_categories);
    }
}
