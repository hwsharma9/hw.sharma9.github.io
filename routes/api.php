<?php

use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CourseEnrollmentController;
use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\Auth\RegisteredUserController;
use App\Http\Controllers\Api\Member\DashboardController;
use App\Http\Controllers\Api\Member\UserController;
use App\Models\MDepartment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/app', [HomeController::class, 'app']);
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/page/{slug}/show', [PageController::class, 'show']);

    Route::apiResource('courses', CourseController::class)->only(['index', 'show']);

    Route::get('departments', function () {
        return response()->json([
            'status' => 200,
            'data' => [
                'departments' => MDepartment::get(),
            ]
        ]);
    });
});
Route::prefix('/auth')->group(function () {
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return User::select(['id', 'first_name', 'last_name', 'email'])->find($request->user()->id);
        });
        Route::apiResource('courses', CourseController::class)->only(['index', 'show']);
        Route::apiResource('courses.enrollments', CourseEnrollmentController::class);
        Route::prefix('/member')->group(function () {
            Route::apiResource('dashboard', DashboardController::class);
            Route::get('courses', [UserController::class, 'userCourses']);
        });
    });
});
