<?php

use App\Http\Controllers\manage\CourseRemarkController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\manage\CaptchaController;
use App\Http\Controllers\manage\LocalizationController;
use App\Http\Controllers\manage\ProfileController;
use App\Http\Middleware\IsAccountVerified;
use App\Http\Middleware\IsPasswordChange;
use App\Http\Middleware\Localization;
use App\Http\Middleware\RoutePermission;
use App\Http\Services\JsonService;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\manage\AdminController;
use App\Http\Controllers\manage\AdminRoleController;
use App\Http\Controllers\manage\CourseCategoryController;
use App\Http\Controllers\manage\CourseController;
use App\Http\Controllers\manage\CourseMediaController;
use App\Http\Controllers\manage\ErrorLogController;
use App\Models\DbControllerRoute;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('localization/{locale}', LocalizationController::class)->name('localization');
Route::get('change-role/{role}', function (Role $role) {
    session(['role_name' => $role->name]);
    return redirect()->back();
})->name('change-role');
Route::get('tree', [ExportController::class, 'tree']);
Route::get('export/{table}', [ExportController::class, 'exportTable']);

/**
 * Ajax Routes Start
 */
Route::post('ajax/get-users-by-role', [AdminController::class, 'getUsersByRole'])->name('ajax.users-by-role');
Route::get('ajax/get-content-managers', [AdminController::class, 'getContentManagers'])->name('ajax.get-content-managers');
Route::patch('ajax/admin_roles/{admin_role}/update-status', [AdminRoleController::class, 'updateStatus'])->name('ajax.update-addition-role-status');
Route::delete('ajax/course_topic/{course_topic}/destroy', [CourseController::class, 'deleteCourseTopic'])->name('ajax.course-topic.destroy');
Route::post('ajax/media/{course_media}/delete', [CourseController::class, 'deleteCourseMedia'])->name('ajax.course.media.destroy');
Route::post('ajax/course/{course}/update-status', [CourseController::class, 'updateCourseStatus'])->name('ajax.course.update-status');
/**
 * Ajax Routes End
 */

Route::redirect('/manage', '/manage/login');


Route::prefix('manage')->group(static function () {
    Route::get('load-captcha', CaptchaController::class)->name('load-captcha');

    // Guest routes
    Route::middleware('guest:admin')->group(static function () {
        // Auth routes
        Route::get('login', [\App\Http\Controllers\manage\Auth\AuthenticatedSessionController::class, 'create'])->name('manage.login');
        Route::post('login', [\App\Http\Controllers\manage\Auth\AuthenticatedSessionController::class, 'store'])->name('manage.login');
        // Forgot password
        Route::get('forgot-password', [\App\Http\Controllers\manage\Auth\PasswordResetLinkController::class, 'create'])->name('manage.password.request');
        Route::post('forgot-password', [\App\Http\Controllers\manage\Auth\PasswordResetLinkController::class, 'store'])->name('manage.password.email');
        // Reset password
        Route::get('reset-password/{token}', [\App\Http\Controllers\manage\Auth\NewPasswordController::class, 'create'])->name('admin.password.reset');
        Route::post('reset-password', [\App\Http\Controllers\manage\Auth\NewPasswordController::class, 'store'])->name('manage.password.update');
    });

    // Route::middleware('auth')->group(static function () {
    // OTP Verification
    Route::get('verify/otp/{admin}', [\App\Http\Controllers\manage\Auth\VerifyOTPController::class, 'create'])->name('manage.otp.verification');
    Route::post('verify/otp/{admin}', [\App\Http\Controllers\manage\Auth\VerifyOTPController::class, 'store'])->name('manage.otp.verification');
    // });

    // Verify email routes
    Route::middleware(['auth:admin'])->group(static function () {
        Route::get('verify-email', [\App\Http\Controllers\manage\Auth\EmailVerificationPromptController::class, '__invoke'])->name('manage.verification.notice');
        Route::get('verify-email/{id}/{hash}', [\App\Http\Controllers\manage\Auth\VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('manage.verification.verify');
        Route::post('email/verification-notification', [\App\Http\Controllers\manage\Auth\EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('manage.verification.send');
    });

    // Authenticated routes
    Route::middleware(['auth:admin'])->group(static function () {
        // Confirm password routes
        Route::get('confirm-password', [\App\Http\Controllers\manage\Auth\ConfirmablePasswordController::class, 'show'])->name('manage.password.confirm');
        Route::post('confirm-password', [\App\Http\Controllers\manage\Auth\ConfirmablePasswordController::class, 'store']);
        // Logout route
        Route::post('logout', [\App\Http\Controllers\manage\Auth\AuthenticatedSessionController::class, 'destroy'])->name('manage.logout');
        // General routes
        // Route::get('/', [\App\Http\Controllers\manage\HomeController::class, 'index'])->name('manage.index');
        // Route::get('/home', [\App\Http\Controllers\manage\HomeController::class, 'index'])->name('manage.home');
        // Route::get('profile', [\App\Http\Controllers\manage\HomeController::class, 'profile'])->middleware('password.confirm.admin')->name('manage.profile');

        Route::name('manage.')->group(function () {
            // Route::resource('course.remark', CourseRemarkController::class);
            // Error Logs route
            Route::get('error-logs', ErrorLogController::class)->name('error-logs');

            Route::get('load-captcha', CaptchaController::class)->name('load-captcha');
            Route::get('profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
            Route::patch('profile/{admin}/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
            Route::group(['middleware' => [IsPasswordChange::class, IsAccountVerified::class]], function () {
                Route::get('profile/{admin}/edit', [ProfileController::class, 'edit'])->name('profile');
                Route::patch('profile/{admin}', [ProfileController::class, 'update'])->name('profile.update');
                Route::post('profile/{admin}/verified-otp', [ProfileController::class, 'sendOTP'])->name('profile.verified-otp');
                Route::post('profile/{admin}/image-upload', [ProfileController::class, 'uploadProfileImage'])->name('profile.image-upload');

                Route::get('download-media/{media}', CourseMediaController::class)->name('download-media');

                Route::group(['middleware' => [Localization::class, RoutePermission::class]], function () {
                    $db_controller_routes =  DbControllerRoute::whereHas('dbController', function ($query) {
                        $query->where('resides_at', 'manage');
                    })->with(['dbController' => function ($query) {
                        $query->where('resides_at', 'manage');
                    }])->get();

                    if ($db_controller_routes) {
                        foreach ($db_controller_routes as $db_controller_route) {
                            // print_r($db_controller_route->dbController->resides_at);
                            // Create the controllers path
                            $controller = trim("app\\Http\\Controllers\\manage\\" . $db_controller_route->dbController->controller_name);
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
                                } else if (in_array($db_controller_route->method, ['post', 'delete'])) {
                                    Route::{$db_controller_route->method}(
                                        $db_controller_route->route,
                                        [
                                            get_class($controller_path), $db_controller_route->function_name
                                        ]
                                    )->name($db_controller_route->named_route);
                                } else {
                                    // If Controller not found return view controller-not-found view
                                    Route::{$db_controller_route->method}($db_controller_route->route, function () use ($db_controller_route) {
                                        return view('admin.errors.controller-not-found')->with(['db_controller_route' => $db_controller_route]);
                                    })->name($db_controller_route->named_route);
                                }
                            }
                        }
                    }

                    /*$db_controller_routes = JsonService::getJson('admin_menu');
                    if ($db_controller_routes) {
                        if ($db_controller_routes) {
                            foreach ($db_controller_routes as $db_controller_route) {
                                if ($db_controller_route->db_controller) {
                                    $controller = trim("App\\Http\\Controllers\\" . (!is_null($db_controller_route->db_controller) ? $db_controller_route->db_controller->resides_at . "\\" : '') . $db_controller_route->db_controller->controller_name);
                                    if (file_exists(base_path($controller . ".php"))) {
                                        $controller_path = new $controller();
                                        if ($db_controller_route->method === 'get') {
                                            Route::match([$db_controller_route->method, 'post'], $db_controller_route->route, [get_class($controller_path), $db_controller_route->function_name])->name($db_controller_route->named_route)->withTrashed();
                                        } else {
                                            Route::{$db_controller_route->method}($db_controller_route->route, [get_class($controller_path), $db_controller_route->function_name])->name($db_controller_route->named_route)->withTrashed();
                                        }
                                    } else {
                                        Route::{$db_controller_route->method}($db_controller_route->route, function () use ($db_controller_route) {
                                            return view('admin.errors.controller-not-found')->with(['db_controller_route' => $db_controller_route]);
                                        })->name($db_controller_route->named_route)->withTrashed();
                                    }
                                }
                            }
                        }
                    }*/
                });
            });
        });
    });
});
