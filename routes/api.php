<?php

use App\Http\Controllers\UserApiController;
use App\Http\Controllers\WorkEntryApiController;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::controller(UserApiController::class)->prefix('user')->group(function () {
    Route::get('all', 'index');
    Route::post('create', 'store');
    Route::put('{user}', 'update');
    Route::delete('{user}', 'delete');
    Route::get('{user}', 'show');
    Route::get('{user}/workentry', 'workEntries');
});

Route::controller(WorkEntryApiController::class)->prefix('workentry')->group(function () {
    Route::post('create', 'store');
    Route::put('{workentry}', 'update');
    Route::delete('{workentry}', 'delete');
    Route::get('{workentry}', 'show');
});
