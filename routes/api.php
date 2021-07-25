<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// いいね
Route::match(['get', 'post'], '/job/{id}/like', [LikeController::class, 'like'])->name('job.like');
// いいね解除
Route::match(['get', 'post'], '/job/{id}/unlike', [LikeController::class, 'unlike'])->name('job.like');
