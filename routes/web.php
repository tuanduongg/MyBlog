<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

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
//client

Route::get('/', [HomeController::class, 'index']);
Route::get('/bai-viet/{slug}', [HomeController::class, 'ShowPost'])->name('ShowPost');
Route::get('/danh-muc/{slug}', [HomeController::class, 'ShowPostsCategory']);
Route::get('/tag/{name}', [HomeController::class, 'ShowPostsTag']);
Route::get('/tags', [HomeController::class, 'GetAllCategory'])->name('tags');
Route::get('/lien-he', [HomeController::class, 'ShowContact']);


//admin
Route::group([
    'prefix' => 'admin',
    'middleware' => 'auth',
], function () {
   
    Route::get('/dashboard', [AdminController::class, 'DashBoard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'Users'])->name('admin.users')->middleware('CheckSuperAdmin');

    //posts
    Route::get('/posts', [PostController::class, 'index'])->name('admin.posts');
    Route::get('/posts/create', [PostController::class, 'create'])->name('admin.posts.create');
    Route::post('/posts/store', [PostController::class, 'store'])->name('admin.posts.store');
    Route::get('/posts/edit/{id}', [PostController::class, 'edit'])->name('admin.posts.edit');
    Route::put('/posts/update/{id}', [PostController::class, 'update'])->name('admin.posts.update');
    Route::get('/posts/destroy', [PostController::class, 'destroy'])->name('admin.posts.destroy');
    Route::get('/posts/tags/search', [PostController::class, 'FindTags']);
    Route::get('/posts/categories/search', [PostController::class, 'FindCategories']);
    Route::post('/posts/ckeditor/uploadphoto', [PostController::class, 'UpLoadPhotoCkEditor'])->name('UpLoadPhotoCkEditor');
    Route::get('/posts/ckeditor/filebrowser', [PostController::class, 'filebrowser'])->name('file-browser');


    //categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories');

    Route::get('/profile', [AdminController::class, 'Profile'])->name('admin.profile');
    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.auth.logout');
    //auth
});

Route::post('/admin/login', [AuthController::class, 'processLogin']);
Route::get('/admin/login', [AuthController::class, 'login'])->name('admin.auth.login');
