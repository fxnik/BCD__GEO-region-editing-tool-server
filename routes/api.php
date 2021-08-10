<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegionController;
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

//-----------------------------------------------------------------------------------------------------------------------

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get("/users",   [AuthController::class, 'users']);
Route::middleware('auth:sanctum')->get("/refresh", [AuthController::class, 'refresh']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

//-----------------------------------------------------------------------------------------------------------------------

Route::middleware('auth:sanctum')->post("/add_region", [RegionController::class, 'addRegion']);
Route::middleware('auth:sanctum')->post("/update_region", [RegionController::class, 'updateRegion']);
Route::middleware('auth:sanctum')->post("/get_regions_info", [RegionController::class, 'getRegionsInfo']);
Route::middleware('auth:sanctum')->post("/delete_region", [RegionController::class, 'deleteRegion']);
Route::middleware('auth:sanctum')->post("/get_one_region", [RegionController::class, 'getOneRegion']);
Route::middleware('auth:sanctum')->post("/get_all_regions_geojson", [RegionController::class, 'getAllRegionsGeoJson']);
Route::middleware('auth:sanctum')->post("/import_regions", [RegionController::class, 'importRegions']);

//-----------------------------------------------------------------------------------------------------------------------

Route::get('/debug', [AuthController::class, 'outputConcole']);


