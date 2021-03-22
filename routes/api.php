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
Route::get('/products', [App\Http\Controllers\ProductionController::class, 'index']);
Route::delete('/products/admin', [App\Http\Controllers\ProductionController::class, 'Remove']);
Route::put('/products/admin', [App\Http\Controllers\ProductionController::class, 'Edit']);
Route::post('/products/admin', [App\Http\Controllers\ProductionController::class, 'Add']);
Route::get('/products/sold', [App\Http\Controllers\ProductionController::class, 'GetSoldOnDate']);
Route::post('/products/sold', [App\Http\Controllers\ProductionController::class, 'AddSold']);
Route::get('/products/operations', [App\Http\Controllers\ProductionController::class, 'Operations']);
Route::delete('/products/operations', [App\Http\Controllers\ProductionController::class, 'Remove']);
//Route::get('/products/stock', [App\Http\Controllers\ProductionController::class, 'GetStockByProduct']);


// Materials
Route::get('/materials/get', [App\Http\Controllers\MaterialsController::class, 'index']);
Route::get('/materials/qty', [App\Http\Controllers\MaterialsController::class, 'getQty']);
Route::delete('/materials/remove', [App\Http\Controllers\MaterialsController::class, 'Remove']);
Route::post('/materials/edit', [App\Http\Controllers\MaterialsController::class, 'Edit']);
Route::post('/materials/add', [App\Http\Controllers\MaterialsController::class, 'Add']);

// Machines
Route::get('/machines', [App\Http\Controllers\MachinesController::class, 'index']);
Route::delete('/machines', [App\Http\Controllers\MachinesController::class, 'Remove']);
Route::put('/machines', [App\Http\Controllers\MachinesController::class, 'Edit']);
Route::post('/machines', [App\Http\Controllers\MachinesController::class, 'Add']);

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
Route::delete('/incomes/remove', [App\Http\Controllers\MaterialsController::class, 'RemoveIncome']);

// Motohour
Route::get('/motohours', [App\Http\Controllers\MotohoursController::class, 'index']);
Route::post('/motohours', [App\Http\Controllers\MotohoursController::class, 'add']);

// Stock


// Reports
Route::get('/reports/monthly', [App\Http\Controllers\ReportsController::class, 'MonthlyReport']);
Route::get('/reports/upload', [App\Http\Controllers\ReportsController::class, 'UploadReport']);
