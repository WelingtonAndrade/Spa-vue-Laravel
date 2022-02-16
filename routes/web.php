<?php

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
Route::resource('/app/tag', \App\Http\Controllers\Panel\TagController::class)->only('index','show','store','update','destroy');
Route::post('/app/category/imageUpload', [\App\Http\Controllers\Panel\TagController::class, 'imageUpload']);
Route::resource('/app/category', \App\Http\Controllers\Panel\CategoryController::class)->only('index','show','store','update','destroy');

Route::get('{any}' , function (){
    return view('welcome');
})->where('any', '.*');
