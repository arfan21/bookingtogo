<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NationalityController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/nationality",  [NationalityController::class, 'create']);
Route::get("/nationality", [NationalityController::class, 'getAll']);
Route::put("/nationality/{id}", [NationalityController::class, 'update']);
Route::delete("/nationality/{id}", [NationalityController::class, 'delete']);

Route::post("/customer",  [CustomerController::class, 'create']);
Route::get("/customer",  [CustomerController::class, 'getAll']);
Route::put("/customer/{id}",  [CustomerController::class, 'update']);
Route::get("/customer/{id}",  [CustomerController::class, 'getById']);
Route::delete("/customer/{id}",  [CustomerController::class, 'delete']);
