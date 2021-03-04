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
Route::get('/products/getsold', [App\Http\Controllers\ProductionController::class, 'GetSoldOnDate']);
Route::post('/products/addsold', [App\Http\Controllers\ProductionController::class, 'AddSold']);


// Materials
Route::get('/materials/get', [App\Http\Controllers\MaterialsController::class, 'index']);
Route::get('/materials/qty', [App\Http\Controllers\MaterialsController::class, 'getQty']);
Route::delete('/materials/remove', [App\Http\Controllers\MaterialsController::class, 'Remove']);
Route::post('/materials/edit', [App\Http\Controllers\MaterialsController::class, 'Edit']);
Route::post('/materials/add', [App\Http\Controllers\MaterialsController::class, 'Add']);

// Machines
Route::get('/machines/get', [App\Http\Controllers\MachinesController::class, 'index']);
Route::delete('/machines/remove', [App\Http\Controllers\MachinesController::class, 'Remove']);
Route::post('/machines/edit', [App\Http\Controllers\MachinesController::class, 'Edit']);
Route::post('/machines/add', [App\Http\Controllers\MachinesController::class, 'Add']);

// Produced
Route::get('/produced/get', [App\Http\Controllers\ProducedController::class, 'index']);
Route::post('/produced/add', [App\Http\Controllers\ProducedController::class, 'add']);


//Norms
Route::get('/matnorm/get', [App\Http\Controllers\ProductionController::class, 'ShowNorm']);
Route::post('/matnorm/edit', [App\Http\Controllers\ProductionController::class, 'EditNorm']);
Route::delete('/matnorm/remove', [App\Http\Controllers\ProductionController::class, 'RemoveNorm']);

//Incomes
Route::get('/incomes/get', [App\Http\Controllers\MaterialsController::class, 'GetIncomes']);
Route::post('/incomes/add', [App\Http\Controllers\MaterialsController::class, 'AddIncome']);

// Motohour
Route::get('/motohours/get', [App\Http\Controllers\MotohoursController::class, 'index']);
Route::post('/motohours/add', [App\Http\Controllers\MotohoursController::class, 'add']);
