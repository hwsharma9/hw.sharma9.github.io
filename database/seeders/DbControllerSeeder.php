<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\DbController;
use App\Models\DbControllerRoute;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DbControllerSeeder extends Seeder
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
        DB::table('tbl_acl_controllers')->truncate();
        DB::table('tbl_acl_controller_routes')->truncate();
        DB::table('tbl_acl_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $details = [
            [
                'id' => 1,
                'title' => 'Home Page',
                'resides_at' => 'manage',
                'controller_name' => 'HomeController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
                'routes' => [
                    [
                        'id' => 1,
                        'route' => 'home',
                        'named_route' => 'home',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 1,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                ]
            ],
            [
                'id' => 2,
                'title' => 'Manage Access List',
                'resides_at' => 'manage',
                'controller_name' => 'DbControllerController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
                'routes' => [
                    [
                        'id' => 2,
                        'route' => 'dbcontrollers',
                        'named_route' => 'dbcontrollers.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 3,
                        'route' => 'dbcontrollers/create',
                        'named_route' => 'dbcontrollers.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 4,
                        'route' => 'dbcontrollers/{dbcontroller}/edit',
                        'named_route' => 'dbcontrollers.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 5,
                        'route' => 'dbcontrollers/{dbControllerRoute}/route',
                        'named_route' => 'dbcontrollers.destroyroute',
                        'method' => 'post',
                        'function_name' => 'destroyRoute',
                        'fk_controller_id' => 2,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-12 13:42:07',
                        'updated_at' => '2023-12-12 13:42:07'
                    ],
                ],
            ],
            [
                'id' => 3,
                'title' => 'Manage Privileges',
                'resides_at' => 'manage',
                'controller_name' => 'RoleController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
                'routes' => [
                    [
                        'id' => 6,
                        'route' => 'roles',
                        'named_route' => 'roles.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 7,
                        'route' => 'roles/create',
                        'named_route' => 'roles.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 8,
                        'route' => 'roles/{role}/edit',
                        'named_route' => 'roles.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 3,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                ]
            ],
            [
                'id' => 4,
                'title' => 'Manage Permissions',
                'resides_at' => 'manage',
                'controller_name' => 'PermissionController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
                'routes' => [
                    [
                        'id' => 9,
                        'route' => 'permissions',
                        'named_route' => 'permissions.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 4,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 10,
                        'route' => 'permissions/create',
                        'named_route' => 'permissions.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 4,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 11,
                        'route' => 'permissions/{permission}/edit',
                        'named_route' => 'permissions.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 4,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                ]
            ],
            [
                'id' => 5,
                'title' => 'Assign User Access',
                'resides_at' => 'manage',
                'controller_name' => 'AssignUserAccessController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-11-06 18:11:01',
                'updated_at' => '2023-11-06 18:11:01',
                'routes' => [
                    [
                        'id' => 12,
                        'route' => 'acl/index',
                        'named_route' => 'acl.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-06 18:11:01',
                        'updated_at' => '2023-11-06 18:11:59'
                    ],
                    [
                        'id' => 13,
                        'route' => 'acl/create',
                        'named_route' => 'acl.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-06 18:11:01',
                        'updated_at' => '2023-11-06 18:11:59'
                    ],
                    [
                        'id' => 14,
                        'route' => 'acl/{acl}/edit',
                        'named_route' => 'acl.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 5,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-06 18:11:01',
                        'updated_at' => '2023-11-06 18:11:59'
                    ],
                ]
            ],
            [
                'id' => 6,
                'title' => 'Manage Admin Menus',
                'resides_at' => 'manage',
                'controller_name' => 'AdminMenuController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
                'routes' => [
                    [
                        'id' => 15,
                        'route' => 'menus/update-all',
                        'named_route' => 'menus.update-all',
                        'method' => 'patch',
                        'function_name' => 'updateAll',
                        'fk_controller_id' => 6,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 16,
                        'route' => 'menus',
                        'named_route' => 'menus.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 6,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 17,
                        'route' => 'menus/create',
                        'named_route' => 'menus.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 6,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 18,
                        'route' => 'menus/{menu}/edit',
                        'named_route' => 'menus.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 6,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 19,
                        'route' => 'menus/{menu}',
                        'named_route' => 'menus.destroy',
                        'method' => 'post',
                        'function_name' => 'destroy',
                        'fk_controller_id' => 6,
                        'status' => 1,
                        'created_by' => null,
                        'updated_by' => null,
                        'created_at' => '2023-12-12 13:42:07',
                        'updated_at' => '2023-12-12 13:42:07'
                    ],
                ]
            ],
            [
                'id' => 7,
                'title' => 'Manage Admins',
                'resides_at' => 'manage',
                'controller_name' => 'AdminController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
                'routes' => [
                    [
                        'id' => 20,
                        'route' => 'admins',
                        'named_route' => 'admins.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 7,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 21,
                        'route' => 'admins/create',
                        'named_route' => 'admins.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 7,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 22,
                        'route' => 'admins/{admin}/edit',
                        'named_route' => 'admins.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 7,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                ]
            ],
            [
                'id' => 8,
                'title' => 'Manage Frontend Users',
                'resides_at' => 'manage',
                'controller_name' => 'UserController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
                'routes' => [
                    [
                        'id' => 23,
                        'route' => 'users',
                        'named_route' => 'users.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 8,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 24,
                        'route' => 'users/create',
                        'named_route' => 'users.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 8,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 25,
                        'route' => 'users/{user}/edit',
                        'named_route' => 'users.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 8,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                ]
            ],
            [
                'id' => 9,
                'title' => 'Manage Frontend Menu',
                'resides_at' => 'manage',
                'controller_name' => 'FrontMenuModuleController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
                'routes' => [
                    [
                        'id' => 26,
                        'route' => 'frontmenumodules',
                        'named_route' => 'frontmenumodules.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 9,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 27,
                        'route' => 'frontmenumodules/create',
                        'named_route' => 'frontmenumodules.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 9,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 28,
                        'route' => 'frontmenumodules/{frontmenumodule}/edit',
                        'named_route' => 'frontmenumodules.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 9,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                ]
            ],
            [
                'id' => 10,
                'title' => 'Manage Upload Media Files',
                'resides_at' => 'manage',
                'controller_name' => 'MediaController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
                'routes' => [
                    [
                        'id' => 29,
                        'route' => 'medias',
                        'named_route' => 'medias.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 10,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 30,
                        'route' => 'medias/create',
                        'named_route' => 'medias.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 10,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 31,
                        'route' => 'medias/{media}/edit',
                        'named_route' => 'medias.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 10,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                ]
            ],
            [
                'id' => 11,
                'title' => 'Manage Frontend Pages',
                'resides_at' => 'manage',
                'controller_name' => 'PageController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
                'routes' => [
                    [
                        'id' => 32,
                        'route' => 'pages',
                        'named_route' => 'pages.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 11,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 33,
                        'route' => 'pages/create',
                        'named_route' => 'pages.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 11,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 34,
                        'route' => 'pages/{page}/edit',
                        'named_route' => 'pages.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 11,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                ]
            ],
            [
                'id' => 12,
                'title' => 'Manage Social Links',
                'resides_at' => 'manage',
                'controller_name' => 'SocialController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
                'routes' => [
                    [
                        'id' => 35,
                        'route' => 'socials',
                        'named_route' => 'socials.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 12,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 36,
                        'route' => 'socials/create',
                        'named_route' => 'socials.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 12,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 37,
                        'route' => 'socials/{social}/edit',
                        'named_route' => 'socials.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 12,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                ]
            ],
            [
                'id' => 13,
                'title' => 'Manage Sliders',
                'resides_at' => 'manage',
                'controller_name' => 'SliderController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => NOW(),
                'updated_at' => NOW(),
                'routes' => [
                    [
                        'id' => 38,
                        'route' => 'sliders/{type}/list',
                        'named_route' => 'sliders.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 13,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 39,
                        'route' => 'sliders/create',
                        'named_route' => 'sliders.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 13,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                    [
                        'id' => 40,
                        'route' => 'sliders/{slider}/edit',
                        'named_route' => 'sliders.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 13,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                ],
            ],
            [
                'id' => 14,
                'title' => 'Manage Front Menu',
                'resides_at' => 'manage',
                'controller_name' => 'FrontMenuController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-11-19 18:28:55',
                'updated_at' => '2023-11-19 18:44:43',
                'routes' => [
                    [
                        'id' => 41,
                        'route' => 'frontmenus/{type}/list',
                        'named_route' => 'frontmenus.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 14,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-19 18:28:55',
                        'updated_at' => '2023-11-19 18:40:50'
                    ],
                    [
                        'id' => 42,
                        'route' => 'frontmenus/create',
                        'named_route' => 'frontmenus.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 14,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-19 18:28:55',
                        'updated_at' => '2023-11-19 18:29:45'
                    ],
                    [
                        'id' => 43,
                        'route' => 'frontmenus/edit/{frontmenu}',
                        'named_route' => 'frontmenus.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 14,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-19 18:28:55',
                        'updated_at' => '2023-11-19 18:29:45'
                    ],
                    [
                        'id' => 44,
                        'route' => 'frontmenus/{frontmenu}/delete',
                        'named_route' => 'frontmenus.destroy',
                        'method' => 'post',
                        'function_name' => 'destroy',
                        'fk_controller_id' => 14,
                        'status' => 1,
                        'created_by' => null,
                        'updated_by' => null,
                        'created_at' => '2023-12-12 13:42:07',
                        'updated_at' => '2023-12-12 13:42:07'
                    ],
                    [
                        'id' => 45,
                        'route' => 'frontmenus/update-all',
                        'named_route' => 'frontmenus.update-all',
                        'method' => 'post',
                        'function_name' => 'updateAll',
                        'fk_controller_id' => 14,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-16 17:05:02',
                        'updated_at' => '2023-11-16 17:05:02'
                    ],
                ]
            ],
            [
                'id' => 15,
                'title' => 'manage DashboardController',
                'resides_at' => 'root',
                'controller_name' => 'DashboardController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-11-17 22:54:11',
                'updated_at' => '2023-11-17 22:54:11',
                'routes' => [
                    [
                        'id' => 46,
                        'route' => 'dashboard',
                        'named_route' => 'dashboard.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 15,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-17 22:54:11',
                        'updated_at' => '2023-11-17 22:54:11'
                    ],
                ]
            ],
            [
                'id' => 16,
                'title' => 'Page Manager for Front End',
                'resides_at' => 'root',
                'controller_name' => 'PageController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-11-19 10:06:19',
                'updated_at' => '2023-11-19 10:06:19',
                'routes' => [
                    [
                        'id' => 47,
                        'route' => 'pages/{page}',
                        'named_route' => 'page.show',
                        'method' => 'get',
                        'function_name' => 'show',
                        'fk_controller_id' => 16,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-19 10:06:19',
                        'updated_at' => '2023-11-19 10:06:19'
                    ],
                ]
            ],
            [
                'id' => 17,
                'title' => 'Office Onboarding',
                'resides_at' => 'manage',
                'controller_name' => 'OfficeOnboardingController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-11-29 17:22:54',
                'updated_at' => '2023-11-29 17:29:50',
                'routes' => [
                    [
                        'id' => 48,
                        'route' => 'officeonboardings/index',
                        'named_route' => 'officeonboardings.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 17,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-29 17:22:54',
                        'updated_at' => '2023-11-30 11:09:39'
                    ],
                    [
                        'id' => 49,
                        'route' => 'officeonboardings/create',
                        'named_route' => 'officeonboardings.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 17,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-29 17:23:57',
                        'updated_at' => '2023-11-30 11:09:39'
                    ],
                    [
                        'id' => 50,
                        'route' => 'officeonboardings/{officeonboarding}/edit',
                        'named_route' => 'officeonboardings.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 17,
                        'status' => 1,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-11-29 17:23:57',
                        'updated_at' => '2023-11-30 11:09:39'
                    ],
                ]
            ],
            [
                'id' => 18,
                'title' => 'Manage Important Links',
                'resides_at' => 'manage',
                'controller_name' => 'ImpLinkController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-12-05 15:18:28',
                'updated_at' => '2023-12-05 15:19:40',
                'routes' => [
                    [
                        'id' => 51,
                        'route' => 'imp_links/index',
                        'named_route' => 'implinks.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 18,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-05 15:18:28',
                        'updated_at' => '2023-12-05 15:19:31'
                    ],
                    [
                        'id' => 52,
                        'route' => 'imp_links/create',
                        'named_route' => 'implinks.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 18,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-05 15:18:28',
                        'updated_at' => '2023-12-05 15:19:31'
                    ],
                    [
                        'id' => 53,
                        'route' => 'imp_links/{implink}/edit',
                        'named_route' => 'implinks.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 18,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-05 15:18:28',
                        'updated_at' => '2023-12-05 15:19:31'
                    ],
                ]
            ],
            [
                'id' => 19,
                'title' => 'Manage Course',
                'resides_at' => 'manage',
                'controller_name' => 'CourseController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-12-07 21:43:52',
                'updated_at' => '2023-12-07 21:44:29',
                'routes' => [
                    [
                        'id' => 54,
                        'route' => 'courses/index',
                        'named_route' => 'courses.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 19,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-07 21:43:52',
                        'updated_at' => '2023-12-07 22:52:49'
                    ],
                    [
                        'id' => 55,
                        'route' => 'courses/create',
                        'named_route' => 'courses.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 19,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-07 21:43:52',
                        'updated_at' => '2023-12-07 22:52:49'
                    ],
                    [
                        'id' => 56,
                        'route' => 'courses/{course}/edit',
                        'named_route' => 'courses.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 19,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-07 21:43:52',
                        'updated_at' => '2023-12-07 22:52:49'
                    ],
                    [
                        'id' => 75,
                        'route' => 'courses/{course}/view',
                        'named_route' => 'courses.show',
                        'method' => 'get',
                        'function_name' => 'show',
                        'fk_controller_id' => 19,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => NULL,
                        'created_at' => '2024-01-12 11:26:57',
                        'updated_at' => '1970-01-01 00:00:00'
                    ],
                ],
            ],
            [
                'id' => 20,
                'title' => 'Manage Additional Charge',
                'resides_at' => 'manage',
                'controller_name' => 'AdminRoleController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-12-15 17:00:43',
                'updated_at' => '2023-12-15 17:01:27',
                'routes' => [
                    [
                        'id' => 57,
                        'route' => 'admin_roles/index',
                        'named_route' => 'admin_roles.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 20,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-15 17:00:43',
                        'updated_at' => '2023-12-15 17:01:27'
                    ],
                    [
                        'id' => 58,
                        'route' => 'admin_roles/create/{admin}',
                        'named_route' => 'admin_roles.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 20,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-15 17:00:43',
                        'updated_at' => '2023-12-18 11:48:21'
                    ],
                    [
                        'id' => 59,
                        'route' => 'admin_roles/{admin}/edit/{admin_role}',
                        'named_route' => 'admin_roles.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 20,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-15 17:00:43',
                        'updated_at' => '2023-12-18 11:48:21'
                    ],
                ]
            ],
            [
                'id' => 21,
                'title' => 'Manage Course Category',
                'resides_at' => 'manage',
                'controller_name' => 'CourseCategoryController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-12-20 12:35:51',
                'updated_at' => '2023-12-20 12:36:24',
                'routes' => [
                    [
                        'id' => 60,
                        'route' => 'course_categories/index',
                        'named_route' => 'course_categories.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 21,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-20 12:35:51',
                        'updated_at' => '2023-12-20 12:36:24'
                    ],
                    [
                        'id' => 61,
                        'route' => 'course_categories/create',
                        'named_route' => 'course_categories.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 21,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-20 12:35:51',
                        'updated_at' => '2023-12-20 12:36:24'
                    ],
                    [
                        'id' => 62,
                        'route' => 'course_categories/{course_category}/edit',
                        'named_route' => 'course_categories.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 21,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-20 12:35:51',
                        'updated_at' => '2023-12-20 12:36:24'
                    ],
                ]
            ],
            [
                'id' => 22,
                'title' => 'Manage Course Category Courses',
                'resides_at' => 'manage',
                'controller_name' => 'CourseCategoryCourseController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-12-21 13:24:40',
                'updated_at' => '2023-12-21 13:35:35',
                'routes' => [
                    [
                        'id' => 63,
                        'route' => 'course_category_courses/index',
                        'named_route' => 'course_category_courses.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 22,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-21 13:24:40',
                        'updated_at' => '2023-12-21 13:26:41'
                    ],
                    [
                        'id' => 64,
                        'route' => 'course_category_courses/create',
                        'named_route' => 'course_category_courses.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 22,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-21 13:24:40',
                        'updated_at' => '2023-12-21 13:26:41'
                    ],
                    [
                        'id' => 65,
                        'route' => 'course_category_courses/{course_category_course}/edit',
                        'named_route' => 'course_category_courses.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 22,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-21 13:24:40',
                        'updated_at' => '2023-12-21 13:26:41'
                    ],
                ]
            ],
            [
                'id' => 23,
                'title' => 'Manage Admin Course',
                'resides_at' => 'manage',
                'controller_name' => 'AdminCourseController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2023-12-21 17:03:39',
                'updated_at' => '2023-12-21 17:04:12',
                'routes' => [
                    [
                        'id' => 66,
                        'route' => 'admin_courses/index',
                        'named_route' => 'admin_courses.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 23,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-21 17:03:39',
                        'updated_at' => '2023-12-21 17:04:12'
                    ],
                    [
                        'id' => 67,
                        'route' => 'admin_courses/create',
                        'named_route' => 'admin_courses.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 23,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-21 17:03:39',
                        'updated_at' => '2023-12-21 17:04:12'
                    ],
                    [
                        'id' => 68,
                        'route' => 'admin_courses/{admin_course}/edit',
                        'named_route' => 'admin_courses.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 23,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2023-12-21 17:03:39',
                        'updated_at' => '2023-12-21 17:04:12'
                    ],
                ]
            ],
            [
                'id' => 24,
                'title' => 'Manage Course Configuration',
                'resides_at' => 'manage',
                'controller_name' => 'CourseConfigurationController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2024-01-02 11:55:26',
                'updated_at' => '2024-01-02 11:56:01',
                'routes' => [
                    [
                        'id' => 69,
                        'route' => 'course_configurations/index',
                        'named_route' => 'course_configurations.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 24,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2024-01-02 11:55:26',
                        'updated_at' => '2024-01-02 11:56:01'
                    ],
                    [
                        'id' => 70,
                        'route' => 'course_configurations/create',
                        'named_route' => 'course_configurations.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 24,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2024-01-02 11:55:26',
                        'updated_at' => '2024-01-02 11:56:01'
                    ],
                    [
                        'id' => 71,
                        'route' => 'course_configurations/{course_configuration}/edit',
                        'named_route' => 'course_configurations.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 24,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2024-01-02 11:55:26',
                        'updated_at' => '2024-01-02 11:56:01'
                    ],
                ]
            ],
            [
                'id' => 25,
                'title' => 'Manage Assigned Course',
                'resides_at' => 'manage',
                'controller_name' => 'AssignedCourseController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2024-01-06 09:41:18',
                'updated_at' => '2024-01-06 09:41:31',
                'routes' => [
                    [
                        'id' => 72,
                        'route' => 'assigned_courses/index',
                        'named_route' => 'assigned_courses.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 25,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => NULL,
                        'created_at' => '2024-01-06 09:41:18',
                        'updated_at' => '2024-01-06 09:41:18'
                    ],
                    [
                        'id' => 73,
                        'route' => 'assigned_courses/create',
                        'named_route' => 'assigned_courses.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 25,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => NULL,
                        'created_at' => '2024-01-06 09:41:18',
                        'updated_at' => '2024-01-06 09:41:18'
                    ],
                    [
                        'id' => 74,
                        'route' => 'assigned_courses/{assigned_course}/edit',
                        'named_route' => 'assigned_courses.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 25,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => NULL,
                        'created_at' => '2024-01-06 09:41:18',
                        'updated_at' => '2024-01-06 09:41:18'
                    ],
                ]
            ],
            [
                'id' => 26,
                'title' => 'Manage Course Approval Request',
                'resides_at' => 'manage',
                'controller_name' => 'CourseApprovalRequestController',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2024-01-15 16:05:13',
                'updated_at' => '2024-01-15 16:05:41',
                'routes' => [
                    [
                        'id' => 76,
                        'route' => 'course/{course}/request/create',
                        'named_route' => 'course.request.create',
                        'method' => 'get',
                        'function_name' => 'create',
                        'fk_controller_id' => 26,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2024-01-15 16:05:13',
                        'updated_at' => '2024-01-15 16:06:12'
                    ],
                    [
                        'id' => 77,
                        'route' => 'course/{course}/request/index',
                        'named_route' => 'course.request.index',
                        'method' => 'get',
                        'function_name' => 'index',
                        'fk_controller_id' => 26,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => NULL,
                        'created_at' => '2024-01-17 07:33:25',
                        'updated_at' => '1970-01-01 00:00:00'
                    ],
                    [
                        'id' => 78,
                        'route' => 'course/{course}/request/{approval_request}/edit',
                        'named_route' => 'course.request.edit',
                        'method' => 'get',
                        'function_name' => 'edit',
                        'fk_controller_id' => 26,
                        'status' => 0,
                        'created_by' => 1,
                        'updated_by' => 1,
                        'created_at' => '2024-01-17 07:49:24',
                        'updated_at' => '2024-02-06 11:38:19'
                    ],
                ]
            ],
        ];
        foreach ($details as $key => $controller) {
            $routes = $controller['routes'];
            unset($controller['routes']);
            $controller_id = DbController::insertGetId($controller);
            $controller_name = trim($controller['controller_name']);
            if ($routes) {
                foreach ($routes as $route) {
                    $route['fk_controller_id'] = $controller_id;
                    $function_name = trim($route['function_name']);
                    $id = DbControllerRoute::insertGetId($route);
                    if ($controller['resides_at'] == 'manage') {
                        $permission = [
                            'name' => $controller_name . " " . $function_name,
                            'guard_name' => ($controller['resides_at'] == 'manage') ? 'admin' : $controller['resides_at'],
                            'fk_controller_route_id' => $id
                        ];
                        Permission::create($permission);
                    }
                }
            }
        }
    }
}
