<?php

use App\Http\Middleware\Localization;
use App\Models\DbControllerRoute;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::group(['middleware' => [Localization::class]], function () {
    Route::name(config('constents.resides_at.root') . '.')->group(
        function () {
            if (Schema::hasTable('tbl_acl_controller_routes')) {
                // Fetch only routes created for the controller files resides at
                // 'app/Http/Controllers' Folder
                $db_controller_routes =  DbControllerRoute::whereHas('dbController', function ($query) {
                    $query->where('resides_at', 'root');
                })->with(['dbController' => function ($query) {
                    $query->where('resides_at', 'root');
                }])->get();

                if ($db_controller_routes) {
                    foreach ($db_controller_routes as $db_controller_route) {
                        // print_r($db_controller_route->dbController->resides_at);
                        // Create the controllers path
                        $controller = trim("app\\Http\\Controllers\\root\\" . $db_controller_route->dbController->controller_name);
                        // Check if the controller exists in the app/Http/Controllers Folder
                        // If exists then create the route
                        // Else ignore the route
                        if (file_exists(str_replace('\\', '/', base_path($controller . ".php")))) {
                            // Create the object of the controller class
                            $ccp = str_replace('app', 'App', $controller);
                            $controller_path = new $ccp();
                            if ($db_controller_route->method === 'get') {
                                // Create the route
                                // The Match accepts the method provided by the add access list method
                                // all the get method accepts post method too so we used match
                                Route::match([$db_controller_route->method, 'post'], $db_controller_route->route, [get_class($controller_path), $db_controller_route->function_name])->name($db_controller_route->named_route);
                            } else {
                                // If Controller not found return view controller-not-found view
                                Route::{$db_controller_route->method}($db_controller_route->route, function () use ($db_controller_route) {
                                    return view('admin.errors.controller-not-found')->with(['db_controller_route' => $db_controller_route]);
                                })->name($db_controller_route->named_route);
                            }
                        }
                    }
                }
            }
        }
    );
});
