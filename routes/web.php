<?php


use App\Http\Controllers\Admin\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::middleware('role:admin')->prefix('admin_panel')->group(function () {
    Route::middleware('auth')->prefix('admin_panel')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('homeAdmin');

//    Route::resource('/category', CategoryController::class);
//    Route::resource('/post', PostController::class);
});
