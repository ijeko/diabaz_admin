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

Route::middleware(['apiAccess:admin'])->group(function (){
    Route::delete('/products/admin', [App\Http\Controllers\ProductionController::class, 'Remove']);
    Route::delete('/products/operations', [App\Http\Controllers\ProductionController::class, 'Remove']);
    Route::delete('/materials/admin', [App\Http\Controllers\MaterialsController::class, 'Remove']);
    Route::delete('/machines/admin', [App\Http\Controllers\MachinesController::class, 'Remove']);
    Route::post('/matnorm/edit', [App\Http\Controllers\ProductionController::class, 'EditNorm']);
    Route::delete('/matnorm/remove', [App\Http\Controllers\ProductionController::class, 'RemoveNorm']);
    Route::delete('/incomes/remove', [App\Http\Controllers\MaterialsController::class, 'RemoveIncome']);
    Route::put('/admin/users', [App\Http\Controllers\UserController::class, 'EditUser']);
    Route::post('/admin/users', [App\Http\Controllers\UserController::class, 'AddUser']);
    Route::delete('/admin/users', [App\Http\Controllers\UserController::class, 'DeleteUser']);
});

Route::middleware(['apiAccess:admin|office'])->group(function (){
    Route::put('/products/admin', [App\Http\Controllers\ProductionController::class, 'Edit']);
    Route::post('/products/admin', [App\Http\Controllers\ProductionController::class, 'Add']);
    Route::get('/products/operations', [App\Http\Controllers\ProductionController::class, 'Operations']);
    Route::put('/materials/admin', [App\Http\Controllers\MaterialsController::class, 'Edit']);
    Route::post('/materials/admin', [App\Http\Controllers\MaterialsController::class, 'Add']);
    Route::put('/machines/admin', [App\Http\Controllers\MachinesController::class, 'Edit']);
    Route::post('/machines/admin', [App\Http\Controllers\MachinesController::class, 'Add']);
    Route::post('/incomes/add', [App\Http\Controllers\MaterialsController::class, 'AddIncome']);
    Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'GetList']);
    Route::post('/products/sold', [App\Http\Controllers\SoldController::class, 'AddSold']);
});

Route::middleware(['apiAccess:admin|office|gorny'])->group(function () {
    Route::get('/products', [App\Http\Controllers\ProductionController::class, 'index']);
    Route::get('/products/sold', [App\Http\Controllers\ProductionController::class, 'GetSoldOnDate']);
    Route::get('/materials', [App\Http\Controllers\MaterialsController::class, 'GetMaterials']);
    Route::get('/machines', [App\Http\Controllers\MachinesController::class, 'index']);
    Route::get('/produced/get', [App\Http\Controllers\ProducedController::class, 'index']);
    Route::post('/produced/add', [App\Http\Controllers\ProducedController::class, 'add']);
    Route::get('/matnorm/get', [App\Http\Controllers\ProductionController::class, 'ShowNorm']);
    Route::get('/motohours', [App\Http\Controllers\MotohoursController::class, 'index']);
    Route::post('/motohours', [App\Http\Controllers\MotohoursController::class, 'add']);
    Route::get('/incomes/get', [App\Http\Controllers\MaterialsController::class, 'GetIncomes']);
    Route::get('/reports/monthly', [App\Http\Controllers\ReportsController::class, 'MonthlyReport']);
    Route::get('/reports/upload', [App\Http\Controllers\ReportsController::class, 'UploadReport']);
});
