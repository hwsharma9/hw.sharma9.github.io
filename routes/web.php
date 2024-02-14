<?php

use App\Http\Controllers\root\DashboardController;
use App\Http\Middleware\LogsQueries;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::group([LogsQueries::class], function () {
    require __DIR__ . '/auth.php';
    require __DIR__ . '/manage.php';
    require __DIR__ . '/user.php';
    require __DIR__ . '/root.php';
    require __DIR__ . '/api.php';
});
