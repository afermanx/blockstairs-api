<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ColorController;
use App\Http\Controllers\api\ColorUserContoller;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/users', [UserController::class, 'index']);
Route::post('/user', [UserController::class, 'store']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);

Route::get('/colors', [ColorController::class, 'index']);
Route::post('/color', [ColorController::class, 'store']);
Route::get('/color/{id}', [ColorController::class, 'show']);
Route::put('/color/{id}', [ColorController::class, 'update']);
Route::delete('/color/{id}', [ColorController::class, 'destroy']);

Route::post('/bind_color/{user_id}', [ColorUserContoller::class, 'bind']);
Route::post('/unbind_color/{user_id}', [ColorUserContoller::class, 'unbind']);


