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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/brutusin', [App\Http\Controllers\BrutusinController::class, 'index']);

Route::get('/json-forms', [App\Http\Controllers\JsonFormsController::class, 'index']);

Route::get('/get_form_structure',[App\Http\Controllers\HomeController::class, 'get_form_structure']);


Route::post('/json-forms/create', [App\Http\Controllers\JsonFormsController::class, 'create']);

