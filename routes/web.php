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

Route::get('/', function ()
{
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/notify', [App\Http\Controllers\HomeController::class, 'notify'])->name('notify');



Route::prefix('/notification')->as('notification.')->middleware('auth')->group(function ()
{
    Route::get('/', [App\Http\Controllers\NotificationController::class, 'index'])->name('index');
    Route::get('/list', [App\Http\Controllers\NotificationController::class, 'list'])->name('list');
    Route::get('/read/{notification}', [App\Http\Controllers\NotificationController::class, 'read'])->name('read');
    Route::post('/read-all', [App\Http\Controllers\NotificationController::class, 'readAll'])->name('read.all');
    Route::post('/clear-all', [App\Http\Controllers\NotificationController::class, 'clearAll'])->name('clear.all');
});
