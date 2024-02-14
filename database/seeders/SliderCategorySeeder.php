<?php

namespace Database\Seeders;

use App\Models\SliderCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderCategorySeeder extends Seeder
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
        DB::table($tableNames['slider_categories'])->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $slider_category = [
            [
                'id' => 1,
                'cat_title_en' => 'Top Slider',
            ],
            [
                'id' => 2,
                'cat_title_en' => 'Bottom Slider',
            ],
        ];
        SliderCategory::insert($slider_category);
    }
}
