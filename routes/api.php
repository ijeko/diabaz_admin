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
//Route::middleware(['dateSetter'])->get('/workdate', function (Request $request) {
////        session(['currentDate' => $request->currentDate]);
//    return $request->currentDate;
//});
Route::middleware(['dateSetter', 'apiAccess:admin'])->group(function () {
    Route::delete('/products/admin', [App\Http\Controllers\ProductionController::class, 'Remove']);
    Route::delete('/products/operations', [App\Http\Controllers\ProductionController::class, 'Remove']);
    Route::delete('/materials/admin', [App\Http\Controllers\MaterialsController::class, 'RemoveMaterial']);
    Route::delete('/machines/admin', [App\Http\Controllers\MachinesController::class, 'Remove']);
    Route::post('/matnorm/edit', [App\Http\Controllers\ProductionController::class, 'EditMaterialNormsOfProduct']);
    Route::delete('/matnorm/remove', [App\Http\Controllers\ProductionController::class, 'DeleteNormFromProduction']);
    Route::delete('/incomes/remove', [App\Http\Controllers\MaterialsController::class, 'RemoveIncome']);
    Route::put('/admin/users', [App\Http\Controllers\UserController::class, 'EditUser']);
    Route::post('/admin/users', [App\Http\Controllers\UserController::class, 'AddUser']);
    Route::delete('/admin/users', [App\Http\Controllers\UserController::class, 'DeleteUser']);
});

Route::middleware(['dateSetter', 'apiAccess:admin|office'])->group(function () {
    Route::put('/products/admin', [App\Http\Controllers\ProductionController::class, 'EditProduct']);
    Route::post('/products/admin', [App\Http\Controllers\ProductionController::class, 'AddNewProduct']);
    Route::post('/products/spoiled', [App\Http\Controllers\ProductionController::class, 'AddSpoiledProduct']);
    Route::get('/admin/product', [App\Http\Controllers\ProductionController::class, 'GetProductForAdminDashboard']);
    Route::put('/materials/admin', [App\Http\Controllers\MaterialsController::class, 'EditMaterial']);
    Route::post('/materials/admin', [App\Http\Controllers\MaterialsController::class, 'AddNewMaterial']);
    Route::put('/machines/admin', [App\Http\Controllers\MachinesController::class, 'EditMachine']);
    Route::post('/machines/admin', [App\Http\Controllers\MachinesController::class, 'AddNewMachine']);
    Route::post('/incomes/add', [App\Http\Controllers\MaterialsController::class, 'AddNewMaterialIncome']);
    Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'GetList']);
    Route::post('/products/sold', [App\Http\Controllers\ProductionController::class, 'AddSold']);
});

Route::middleware(['dateSetter', 'apiAccess:admin|office|gorny'])->group(function () {
    Route::get('/products', [App\Http\Controllers\ProductionController::class, 'GetProducts']);
    Route::get('/materials', [App\Http\Controllers\MaterialsController::class, 'GetMaterials']);
    Route::get('/machines', [App\Http\Controllers\MachinesController::class, 'GetMachineListWithMonthUsage']);
    Route::get('/produced/get', [App\Http\Controllers\ProducedController::class, 'index']);
    Route::post('/produced/add', [App\Http\Controllers\ProductionController::class, 'AddProduced']);
    Route::get('/matnorm/get', [App\Http\Controllers\ProductionController::class, 'GetMaterialsNormsForProduct']);
    Route::post('/motohours', [App\Http\Controllers\MachinesController::class, 'AddUsage']);
    Route::get('/incomes/get', [App\Http\Controllers\MaterialsController::class, 'GetMonthlyMaterialIncome']);
    Route::get('/reports/monthly', [App\Http\Controllers\ReportsController::class, 'MonthlyProductionReport']);
    Route::get('/reports/upload', [App\Http\Controllers\ReportsController::class, 'MonthlyUploadReport']);
    Route::get('/reports', [App\Http\Controllers\ReportsController::class, 'YearlyProductionInTonsReport']);
});
