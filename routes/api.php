<?php

use App\Http\Controllers\pos\BoxsController;
use App\Http\Controllers\pos\DelegateSalesController;
use App\Http\Controllers\pos\GroupsController;
use App\Http\Controllers\pos\PaymentMethodController;
use App\Http\Controllers\pos\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Users 
Route::get('/get-users', [UsersController::class, 'getPersons']);
Route::get('/get-groups', [GroupsController::class, 'groups']);
Route::get('/get-items', [GroupsController::class, 'items']);
Route::get('/get-items-barcode', [GroupsController::class, 'searchBarcode']);
Route::get('/get-items-name', [GroupsController::class, 'searchByNameAr']);




Route::get('/get-items-details', [GroupsController::class, 'getItemPrices']);


Route::get('/get-delegate-sales', [DelegateSalesController::class, 'delegateSales']);


Route::get('/get-payment', [PaymentMethodController::class, 'payment']);
Route::get('/get-box', [BoxsController::class, 'getBox']);





