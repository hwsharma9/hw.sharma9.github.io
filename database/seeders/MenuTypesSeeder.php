<?php

namespace Database\Seeders;

use App\Models\FrontMenuType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuTypesSeeder extends Seeder
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
        DB::table($tableNames['front_menu_types'])->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $menu_types = [
            [
                'id' => 1,
                'title' => 'Top Menu',
            ],
            [
                'id' => 2,
                'title' => 'Footer Menu',
            ],
            [
                'id' => 3,
                'title' => 'Side Menu',
            ],
        ];
        FrontMenuType::insert($menu_types);
    }
}
