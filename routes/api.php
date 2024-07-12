<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\RoleController;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::prefix('api')->group(function () {
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('invoices', InvoiceController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('subscriptions', SubscriptionController::class);
    Route::apiResource('category', CategoryController::class);
});

//les routes pour lister tous les models 
Route::get('/listCategories',[CategoryController::class,'index']);
Route::get('/listClient',[ClientController::class,'index']);
Route::get('/listInvoice',[InvoiceController::class,'index']);
Route::get('/listProduct',[ProductController::class,'index']);
Route::get('/listSubscription',[SubscriptionController::class,'index']);
Route::get('/listUser',[UserController::class,'index']);
Route::get('/listInvoiceItem',[InvoiceItemController::class,'index']);
Route::get('/listPayment',[PaymentController::class,'index']);
Route::get('/listRole',[RoleController::class,'index']);

// Les routes pour ajouter des models
Route::post('/AddCategories',[CategoryController::class,'create']);
Route::post('/AddClients',[ClientController::class,'create']);
Route::post('/AddInvoices',[InvoiceController::class,'create']);
Route::post('/AddProducts',[ProductController::class,'create']);
Route::post('/AddSubscriptions',[SubscriptionController::class,'create']);
Route::post('/AddUsers',[UserController::class,'create']);
Route::post('/AddInvoiceItems',[InvoiceItemController::class,'create']);
Route::post('/AddPayments',[PaymentController::class,'create']);
Route::post('/AddRoles',[RoleController::class,'create']);

// Les routes pour faire des modifications 
Route::put('/updateCategories/{id}',[CategoryController::class,'update']);
Route::put('/updateClients/{id}',[ClientController::class,'update']);
Route::put('/updateInvoices/{id}',[InvoiceController::class,'update']);
Route::put('/updateProducts/{id}',[ProductController::class,'update']);
Route::put('/updateSubscriptions/{id}',[SubscriptionController::class,'update']);
Route::put('/updateUsers/{id}',[UserController::class,'update']);
Route::put('/updateInvoiceItems/{id}',[InvoiceItemController::class,'update']);
Route::put('/updatePayments/{id}',[PaymentController::class,'update']);
Route::put('/updateRoles/{id}',[RoleController::class,'update']);