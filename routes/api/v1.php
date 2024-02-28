<?php

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

Route::get('unauthorized', function () {
    return response()->json(response_error('Unauthorized.'), 401);
})->name('unauthorized');

Route::namespace('V1')->prefix('v1')->middleware('api.key')->group(function () {
    Route::post('login', 'AuthController@login')->name('auth.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', 'AuthController@logout')->name('auth.logout');
    });
});
