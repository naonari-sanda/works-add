<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;

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
Route::get('/', [JobController::class, 'index']);

Route::get('job/{id}', [JobController::class, 'show'])->name('job');

Auth::routes();

// Route::get('/{any?}', fn() => view('index'))->where('any', '.+');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
