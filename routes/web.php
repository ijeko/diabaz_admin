<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/access', function () {
    return view('access');
})->name('acc');
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/inputdata', [App\Http\Controllers\HomeController::class, 'inputdata'])->name('inputdata');
//Route::get('/reports/{any}', [App\Http\Controllers\ReportsController::class, 'index'])->name('reports');
    Route::get('/admin', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin')->middleware('admin:admin|office');
    Route::get('/reports', [\App\Http\Controllers\ReportsController::class, 'index']);
    Route::get('/plans', [\App\Http\Controllers\PlansController::class, 'index'])->name('plans')->middleware('admin:admin|office');

});


//Route::get('/products/get', [App\Http\Controllers\ProductionController::class, 'getProducts'])->name('products');
//Route::get('/products/get', [App\Http\Controllers\ProductionController::class, 'getProducts'])->name('products');
