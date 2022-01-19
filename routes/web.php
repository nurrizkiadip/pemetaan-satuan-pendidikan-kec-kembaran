<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware(['guest'])->group(function () {
  Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});

Route::middleware(['auth', 'verified', 'prevent_back_history'])->group(function () {
  Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\HomeController::class, 'index'])->name('dashboard');

    Route::resource('/dashboard/school-level', Admin\SchoolLevelController::class)
      ->parameter('school-level', 'school_level')
      ->except(['index', 'show']);

    Route::resource('/dashboard/village', Admin\VillageController::class);
    Route::resource('/dashboard/village/{village}/school', Admin\SchoolController::class)
    ->except(['index']);
  });

});
