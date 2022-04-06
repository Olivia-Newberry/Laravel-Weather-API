<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ApiWeatherController;

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

Route::post('login', [ApiUserController::class, 'authenticate']);
Route::post('register', [ApiUserController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('get_user', [ApiUserController::class, 'get_user']);
    Route::get('logout', [ApiUserController::class, 'logout']);
    Route::get('get_weather', [ApiWeatherController::class, 'get_weather']);
    Route::get('get_locations', [ApiWeatherController::class, 'get_locations']);
});
