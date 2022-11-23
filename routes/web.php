<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\News\CategoriesController;
use App\Http\Controllers\News\NewsController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::match(['get', 'post'], '/add-news-item', [HomeController::class, 'addNewsItem'])->name('add-news-item');

Route::name('news.')
    ->prefix('news')
    ->group(function () {
        Route::get('/categories/', [CategoriesController::class, 'index'])->name('categories');
        Route::get('/news/', [NewsController::class, 'index'])->name('index');
        Route::get('/news/{slug}', [NewsController::class, 'show'])->name('detail');
    });

Route::name('admin.')
    ->prefix('admin')
    ->namespace('Admin')
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('index');
        Route::name('news.')
        ->prefix('news')
        ->group(function () {
            Route::match(['get', 'post'], '/create', [\App\Http\Controllers\Admin\NewsController::class, 'create'])->name('create');
            Route::match(['get', 'post'], '/download', [\App\Http\Controllers\Admin\NewsController::class, 'download'])->name('download');
        });
    });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
