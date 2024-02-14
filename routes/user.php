<?php

use App\Http\Controllers\user\HomeController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Middleware\Localization;
use App\Models\DbControllerRoute;


Route::group(['middleware' => [Localization::class]], function () {
    Route::name(config('constents.resides_at.frontend') . '.')->group(
        function () {
            Route::prefix('user/')->group(function () {
                Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
                Route::get('profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
                Route::patch('profile/{admin}/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
            });
            if (Schema::hasTable('tbl_acl_controller_routes')) {
                // Fetch only routes created for the controller files resides at
                // 'app/Http/Controllers' Folder
                $db_controller_routes =  DbControllerRoute::whereHas('dbController', function ($query) {
                    $query->where('resides_at', 'frontend');
                })->with(['dbController' => function ($query) {
                    $query->where('resides_at', 'frontend');
                }])->get();

                if ($db_controller_routes) {
                    foreach ($db_controller_routes as $db_controller_route) {
                        // print_r($db_controller_route->dbController->resides_at);
                        // Create the controllers path
                        $controller = trim("App\\Http\\Controllers\\user\\" . $db_controller_route->dbController->controller_name);
                        // Check if the controller exists in the app/Http/Controllers Folder
                        // If exists then create the route
                        // Else ignore the route
                        if (file_exists(base_path($controller . ".php"))) {
                            // Create the object of the controller class
                            $controller_path = new $controller();
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
