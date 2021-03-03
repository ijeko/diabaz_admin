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
Route::delete('/products/remove', [App\Http\Controllers\ProductionController::class, 'Remove']);
Route::post('/products/edit', [App\Http\Controllers\ProductionController::class, 'Edit']);
Route::post('/products/add', [App\Http\Controllers\ProductionController::class, 'Add']);


// Materials
Route::get('/materials/get', [App\Http\Controllers\MaterialsController::class, 'index']);
Route::get('/materials/qty', [App\Http\Controllers\MaterialsController::class, 'getQty']);


// Machines

// Produced
Route::get('/produced/get', [App\Http\Controllers\ProducedController::class, 'index']);
Route::post('/produced/add', [App\Http\Controllers\ProducedController::class, 'add']);
Route::get('/matnorm/get', [App\Http\Controllers\ProductionController::class, 'ShowNorm']);
Route::post('/matnorm/edit', [App\Http\Controllers\ProductionController::class, 'EditNorm']);
Route::delete('/matnorm/remove', [App\Http\Controllers\ProductionController::class, 'RemoveNorm']);
Route::get('/incomes/get', [App\Http\Controllers\MaterialsController::class, 'GetIncomes']);
Route::post('/incomes/add', [App\Http\Controllers\MaterialsController::class, 'AddIncome']);
