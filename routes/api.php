<?php

use App\Http\Controllers\pos\BoxsController;
use App\Http\Controllers\pos\DelegateSalesController;
use App\Http\Controllers\pos\GroupsController;
use App\Http\Controllers\pos\PaymentMethodController;
use App\Http\Controllers\pos\SaveDataController;
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
Route::get('/get-customer', [UsersController::class, 'getPersons']);

Route::controller(GroupsController::class)->group(function () {
    Route::get('/get-groups',  'groups');
    Route::get('/get-items',  'items');
    Route::get('/get-items-barcode',  'searchBarcode');
    Route::get('/get-items-name',  'searchByNameAr');
    Route::get('/get-items-details', 'getItemPrices');
});


Route::post('/data-save', [SaveDataController::class, 'save']);




Route::get('/get-delegate-sales', [DelegateSalesController::class, 'delegateSales']);


Route::get('/get-payment', [PaymentMethodController::class, 'payment']);
Route::get('/get-box', [BoxsController::class, 'getBox']);
