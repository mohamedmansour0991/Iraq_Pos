<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\pos\BoxsController;
use App\Http\Controllers\pos\UsersController;
use App\Http\Controllers\pos\GroupsController;
use App\Http\Controllers\pos\SaveDataController;
use App\Http\Controllers\pos\DelegateSalesController;
use App\Http\Controllers\pos\PaymentMethodController;

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
Route::post('/login', [AuthController::class, 'login']);
// Route::middleware('auth:sanctum')->get(function (Request $request) {
// });


// Users 
Route::get('/get-customer', [UsersController::class, 'getPersons']);
Route::get('/get-users', [UsersController::class, 'getUsersWithBranches']);

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
