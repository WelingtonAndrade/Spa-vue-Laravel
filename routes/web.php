<?php

use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\TagController;
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
Route::resource('/app/tag', TagController::class)->only('index','show','store','update','destroy');
Route::post('/app/category/imageUpload', [CategoryController::class, 'imageUpload']);
Route::resource('/app/category', CategoryController::class)->only('index','show','store','update','destroy');
Route::post('app/category/delete_image', [CategoryController::class, 'delete_image']);

Route::get('{any}' , function (){
    return view('welcome');
})->where('any', '.*');
