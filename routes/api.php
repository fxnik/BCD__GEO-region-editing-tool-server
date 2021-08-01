<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get("/users",   [AuthController::class, 'users']);
Route::middleware('auth:sanctum')->get("/refresh", [AuthController::class, 'refresh']);
Route::middleware('auth:sanctum')->get("/user",    [AuthController::class, 'profile']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::get('/debug', [AuthController::class, 'outputConcole']);

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */
