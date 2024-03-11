<?php

use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\CourseController;
use App\Models\MDepartment;
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

Route::get('/app', [HomeController::class, 'app']);
Route::get('/home', [HomeController::class, 'index']);
Route::get('/page/{slug}/show', [PageController::class, 'show']);

Route::apiResource('courses', CourseController::class);

Route::get('departments', function () {
    return response()->json([
        'status' => 200,
        'data' => [
            'departments' => MDepartment::get()
        ]
    ]);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
