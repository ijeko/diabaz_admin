<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Products
Route::get('/products/get', [App\Http\Controllers\ProductionController::class, 'index']);

// Materials
Route::get('/materials/get', [App\Http\Controllers\MaterialsController::class, 'index']);

// Machines

// Produced
Route::get('/produced/get', [App\Http\Controllers\ProducedController::class, 'index']);
Route::post('/produced/add', [App\Http\Controllers\ProducedController::class, 'add']);
