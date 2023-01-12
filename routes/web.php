<?php


use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\Photos\PhotosController;
use App\Http\Controllers\Admin\Photos\SetPhotosController;
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
    return view('login');
});

Auth::routes();

//Route::middleware('role:admin')->prefix('admin_panel')->group(function () {
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('homeAdmin');
//    Route::get('/admin_panel', [HomeController::class, 'index'])->name('homeAdmin');
    Route::get('/photos/create', [PhotosController::class, 'create'])->name('createPhotos');
    Route::post('/photos/file-upload', [PhotosController::class, 'store'])->name('dropzoneFileUpload');
    Route::get('/set_photos', [SetPhotosController::class, 'index'])->name('setPhotos');
    Route::get('/set_photos/create', [SetPhotosController::class, 'create'])->name('createSetPhotos');
});
