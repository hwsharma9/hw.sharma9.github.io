<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('slider_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $slider_category = [
            [
                'id' => 1,
                'cat_title_en' => 'Top Slider',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 2,
                'cat_title_en' => 'Bottom Slider',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
        ];
        Slider::insert($slider_category);
    }
}
