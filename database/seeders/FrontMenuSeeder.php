<?php

namespace Database\Seeders;

use App\Models\DbControllerRoute;
use App\Models\FrontMenu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FrontMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tbl_front_menus')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $page_route = DbControllerRoute::where([
            'named_route' => 'page.show',
            'method' => 'get',
            'function_name' => 'show'
        ])->first();
        $front_menus = [
            [
                'id' => 1,
                'parent_id' => 0,
                'title_hi' => 'मुख्य पृष्ठ',
                'title_en' => 'Home',
                'fk_menu_type_id' => 1,
                'fk_controller_route_id' => 46,
                'fk_page_id' => NULL,
                'open_same_tab' => 0,
                'menu_order' => 1,
                'class_id' => NULL,
                'status' => 1,
                'menu_type' => 2,
                'custom_url' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-11-22 13:28:36',
                'updated_at' => '1970-01-01 00:00:00'
            ],
            [
                'id' => 2,
                'parent_id' => 0,
                'title_hi' => 'हमारे बारे में',
                'title_en' => 'About Us',
                'fk_menu_type_id' => 1,
                'fk_controller_route_id' => 47,
                'fk_page_id' => 10,
                'open_same_tab' => 0,
                'menu_order' => 2,
                'class_id' => NULL,
                'status' => 1,
                'menu_type' => 1,
                'custom_url' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-11-22 13:28:36',
                'updated_at' => '1970-01-01 00:00:00'
            ],
            [
                'id' => 3,
                'parent_id' => 0,
                'title_hi' => 'Courses',
                'title_en' => 'Courses',
                'fk_menu_type_id' => 1,
                'fk_controller_route_id' => 46,
                'fk_page_id' => NULL,
                'open_same_tab' => 0,
                'menu_order' => 3,
                'class_id' => NULL,
                'status' => 1,
                'menu_type' => 2,
                'custom_url' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-11-22 13:28:36',
                'updated_at' => '1970-01-01 00:00:00'
            ],
            [
                'id' => 4,
                'parent_id' => 3,
                'title_hi' => 'MAP-IT - TCU (30)',
                'title_en' => 'MAP-IT - TCU (30)',
                'fk_menu_type_id' => 1,
                'fk_controller_route_id' => 46,
                'fk_page_id' => NULL,
                'open_same_tab' => 0,
                'menu_order' => 4,
                'class_id' => NULL,
                'status' => 1,
                'menu_type' => 2,
                'custom_url' => NULL,
                'created_by' => NULL,
                'updated_by' => 1,
                'created_at' => '2023-11-22 13:28:36',
                'updated_at' => '2024-01-28 14:41:40'
            ],
            [
                'id' => 5,
                'parent_id' => 0,
                'title_hi' => 'डाउनलोड',
                'title_en' => 'Download',
                'fk_menu_type_id' => 1,
                'fk_controller_route_id' => 46,
                'fk_page_id' => NULL,
                'open_same_tab' => 0,
                'menu_order' => 5,
                'class_id' => NULL,
                'status' => 1,
                'menu_type' => 2,
                'custom_url' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-11-22 13:28:36',
                'updated_at' => '1970-01-01 00:00:00'
            ],
            [
                'id' => 6,
                'parent_id' => 0,
                'title_hi' => 'वीडियो',
                'title_en' => 'Video',
                'fk_menu_type_id' => 1,
                'fk_controller_route_id' => NULL,
                'fk_page_id' => NULL,
                'open_same_tab' => 0,
                'menu_order' => 6,
                'class_id' => NULL,
                'status' => 1,
                'menu_type' => 3,
                'custom_url' => 'http://www.google.com',
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-11-22 13:28:36',
                'updated_at' => '1970-01-01 00:00:00'
            ],
            [
                'id' => 7,
                'parent_id' => 0,
                'title_hi' => 'संपर्क',
                'title_en' => 'Contacts',
                'fk_menu_type_id' => 1,
                'fk_controller_route_id' => 47,
                'fk_page_id' => 3,
                'open_same_tab' => 0,
                'menu_order' => 7,
                'class_id' => NULL,
                'status' => 1,
                'menu_type' => 1,
                'custom_url' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-11-22 13:28:36',
                'updated_at' => '1970-01-01 00:00:00'
            ],
            [
                'id' => 8,
                'parent_id' => 0,
                'title_hi' => 'Feedback',
                'title_en' => 'Feedback',
                'fk_menu_type_id' => 2,
                'fk_controller_route_id' => 46,
                'fk_page_id' => NULL,
                'open_same_tab' => 0,
                'menu_order' => 1,
                'class_id' => NULL,
                'status' => 1,
                'menu_type' => 2,
                'custom_url' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-11-24 15:16:40',
                'updated_at' => '1970-01-01 00:00:00'
            ],
            [
                'id' => 9,
                'parent_id' => 0,
                'title_hi' => 'Hyperlink Policy',
                'title_en' => 'Hyperlink Policy',
                'fk_menu_type_id' => 2,
                'fk_controller_route_id' => 47,
                'fk_page_id' => 6,
                'open_same_tab' => 0,
                'menu_order' => 1,
                'class_id' => NULL,
                'status' => 1,
                'menu_type' => 1,
                'custom_url' => NULL,
                'created_by' => NULL,
                'updated_by' => 1,
                'created_at' => '2023-11-24 15:17:12',
                'updated_at' => '2024-02-03 12:00:24'
            ],
            [
                'id' => 10,
                'parent_id' => 0,
                'title_hi' => 'Terms of Use',
                'title_en' => 'Terms of Use',
                'fk_menu_type_id' => 2,
                'fk_controller_route_id' => 47,
                'fk_page_id' => 7,
                'open_same_tab' => 0,
                'menu_order' => 1,
                'class_id' => NULL,
                'status' => 1,
                'menu_type' => 1,
                'custom_url' => NULL,
                'created_by' => NULL,
                'updated_by' => 1,
                'created_at' => '2023-11-24 15:17:34',
                'updated_at' => '2024-02-03 12:09:53'
            ],
            [
                'id' => 11,
                'parent_id' => 0,
                'title_hi' => 'Privacy Policy',
                'title_en' => 'Privacy Policy',
                'fk_menu_type_id' => 2,
                'fk_controller_route_id' => 47,
                'fk_page_id' => 5,
                'open_same_tab' => 0,
                'menu_order' => 1,
                'class_id' => NULL,
                'status' => 1,
                'menu_type' => 1,
                'custom_url' => NULL,
                'created_by' => NULL,
                'updated_by' => 1,
                'created_at' => '2023-11-24 15:17:43',
                'updated_at' => '2024-02-03 12:11:14'
            ],
            [
                'id' => 12,
                'parent_id' => 0,
                'title_hi' => 'Disclaimer',
                'title_en' => 'Disclaimer',
                'fk_menu_type_id' => 2,
                'fk_controller_route_id' => 46,
                'fk_page_id' => NULL,
                'open_same_tab' => 0,
                'menu_order' => 1,
                'class_id' => NULL,
                'status' => 1,
                'menu_type' => 2,
                'custom_url' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-11-24 15:17:52',
                'updated_at' => '1970-01-01 00:00:00'
            ],
            [
                'id' => 13,
                'parent_id' => 0,
                'title_hi' => 'Help',
                'title_en' => 'Help',
                'fk_menu_type_id' => 2,
                'fk_controller_route_id' => 46,
                'fk_page_id' => NULL,
                'open_same_tab' => 0,
                'menu_order' => 1,
                'class_id' => NULL,
                'status' => 1,
                'menu_type' => 2,
                'custom_url' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-11-24 15:17:59',
                'updated_at' => '1970-01-01 00:00:00'
            ],
            [
                'id' => 14,
                'parent_id' => 0,
                'title_hi' => 'FQAs',
                'title_en' => 'FQAs',
                'fk_menu_type_id' => 2,
                'fk_controller_route_id' => 46,
                'fk_page_id' => NULL,
                'open_same_tab' => 0,
                'menu_order' => 1,
                'class_id' => NULL,
                'status' => 1,
                'menu_type' => 2,
                'custom_url' => NULL,
                'created_by' => NULL,
                'updated_by' => NULL,
                'created_at' => '2023-11-24 15:18:07',
                'updated_at' => '1970-01-01 00:00:00'
            ],
        ];
        $this->insertData($front_menus);
    }

    public function insertData($front_menus, $parent_id = 0)
    {
        if ($front_menus) {
            foreach ($front_menus  as $front_menu) {
                if ($parent_id != 0) {
                    $front_menu['parent_id'] = $parent_id;
                }
                $childs = isset($front_menu['childrens']) ? $front_menu['childrens'] : [];
                unset($front_menu['childrens']);
                $front_menu = FrontMenu::create($front_menu);
                if (count($childs) > 0) {
                    $this->insertData($childs, $front_menu->id);
                }
            }
        }
    }
}
