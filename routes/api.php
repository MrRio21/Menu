<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BillsController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProviderController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
//////////// Registration
Route::post('/signup', [AuthController::class ,'store']);
Route::post('/login', [AuthController::class ,'login']);
Route::get('/logout', [AuthController::class ,'logout']);

//////////// Bills
    Route::get('/bill', [BillsController::class ,'index']);
    Route::post('/bill/store', [BillsController::class ,'store']);
    Route::post('/bill/update/{is}', [BillsController::class ,'update']);
    Route::delete('/bill/{id}', [BillsController::class ,'destroy']);


// Route::middleware('auth:sanctum')->group(function () {

    Route::get('/allUsers', [AuthController::class ,'index']);

    /////////// Provider
    Route::get('/provider', [ProviderController::class ,'index']);
    // Route::post('/provider/store', [ProviderController::class ,'store']);
    Route::post('/provider/update/{id}', [ProviderController::class ,'update']);
    Route::post('/provider/updated/{id}', [ProviderController::class ,'updated']);
    Route::delete('/provider/{id}', [ProviderController::class ,'destroy']);

    /////////////// Category
    Route::get('/category', [CategoryController::class ,'index']);
    Route::post('/category/store', [CategoryController::class ,'store']);
    Route::post('/category/update/{id}', [CategoryController::class ,'update']);
    Route::delete('/category/{id}', [CategoryController::class ,'destroy']);

    /////////////// Product
    Route::get('/product', [ProductController::class ,'index']);
    Route::post('/product/store', [ProductController::class ,'store']);
    Route::post('/product/update/{id}', [ProductController::class ,'update']);
    Route::delete('/product/{id}', [ProductController::class ,'destroy']);

    /////////////
    Route::get('/promotionalOffer', [ProductController::class ,'promotionalOfferIndex']);
    Route::post('/promotionalOffer/store', [ProductController::class ,'addOrUpdateOffer']);

    //////////////// branch
    Route::get('/branch', [BranchController::class , 'index']);
    Route::post('/branch/store', [BranchController::class , 'store']);
    Route::post('/branch/update/{id}', [BranchController::class , 'update']);
    Route::delete('/branch/{id}', [BranchController::class , 'destroy']);


// });
