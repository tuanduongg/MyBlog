<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\HomeController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return 1;
// });
Route::get('/categories', [HomeController::class, 'GetAllCategory'])->name('api.categories');
Route::get('/tags', [HomeController::class, 'GetAllTag'])->name('api.tags');
Route::get('/posts/suggest', [HomeController::class, 'GetSuggestPosts'])->name('api.posts.suggest');
// Route::get('/admin/dashboard', [HomeController::class,'GetSuggestPosts'])->name('api.posts.suggest');

Route::group(['prefix' => 'admin'], function () {

    Route::get('/users/search', [UserController::class, 'search'])->name('api.users.seach');
    Route::post('/users/store', [UserController::class, 'store'])->name('api.users.store');
    Route::post('/users/update', [UserController::class, 'update'])->name('api.users.update');
    Route::post('/users/delete', [UserController::class, 'destroy'])->name('api.users.delete');
    //category
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('api.categories.store');
    Route::get('/categories/show/{id}', [CategoryController::class, 'show'])->name('api.categories.show');
    Route::post('/categories/update/{id}', [CategoryController::class, 'update'])->name('api.categories.update');
    Route::get('/categories/delete/{id}', [CategoryController::class, 'destroy'])->name('api.categories.delete');

    Route::get('/dashboard/chartjs/{tableName}', [AdminController::class, 'getDataChart'])->name('api.datachartjs');
});
