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
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;



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

//les routes pour le modele category
Route::get('/listCategories',[CategoryController::class,'index']);
Route::post('/AddCategories',[CategoryController::class,'create']);
Route::put('/updateCategories/{id}',[CategoryController::class,'update']);
Route::delete('/deleteCategories/{id}', [CategoryController::class, 'delete']);


//les routes pour le modele Client

Route::get('/listClient', [ClientController::class, 'index']);
Route::post('/AddClients', [ClientController::class, 'create']);
Route::put('/updateClients/{id}', [ClientController::class, 'update']);
Route::delete('/deleteClients/{id}', [ClientController::class, 'delete']);
Route::get('/clients/{id}', [ClientController::class, 'show']);


//les routes pour le modele Invoice
Route::get('/listInvoice',[InvoiceController::class,'index']);
Route::post('/AddInvoices',[InvoiceController::class,'create']);
Route::put('/updateInvoices/{id}',[InvoiceController::class,'update']);
Route::delete('/deleteInvoices/{id}',[InvoiceController::class,'delete']);
Route::get('/searchInvoice',[InvoiceController::class,'search_invoice']);
Route::get('/create_invoice',[InvoiceController::class,'create_invoice']);
Route::post('/add_invoice',[InvoiceController::class,'add_invoice']);
Route::get('/show_invoice/{id}',[InvoiceController::class,'show_invoice']);
Route::put('/updateInvoice/{id}', [InvoiceController::class, 'updateApprobation']);
Route::put('/update-invoice/{id}', [InvoiceController::class, 'updateInvoiceDetails']);
Route::get('/edit_invoice/{id}',[InvoiceController::class,'edit_invoice']);//route de la fonction qui me permet de modifier une facture
Route::get('/delete_invoice_items/{id}',[InvoiceController::class,'delete_invoice_items']); 
Route::post('/send_invoice/{id}', [InvoiceController::class, 'sendInvoice']);





//les routes pour le modele Product
Route::get('/listProduct',[ProductController::class,'index']);
Route::post('/AddProducts',[ProductController::class,'create']);
Route::put('/updateProducts/{id}',[ProductController::class,'update']);
Route::delete('/deleteProducts/{id}',[ProductController::class,'delete']);


//les routes pour le modele Subsciption
Route::get('/listSubscription',[SubscriptionController::class,'index']);
Route::post('/AddSubscriptions',[SubscriptionController::class,'create']);
Route::put('/updateSubscriptions/{id}',[SubscriptionController::class,'update']);
Route::delete('/deleteSubscriptions/{id}',[SubscriptionController::class,'delete']);


//les routes pour le modele User
Route::get('/listUser',[UserController::class,'index']);
Route::post('/AddUsers',[UserController::class,'create']);
Route::put('/updateUsers/{id}',[UserController::class,'update']);
Route::delete('/deleteUsers/{id}',[UserController::class,'delete']);

//les routes pour le modele InvoiceItem
Route::get('/listInvoiceItem',[InvoiceItemController::class,'index']);
Route::post('/AddInvoiceItems',[InvoiceItemController::class,'create']);
Route::put('/updateInvoiceItems/{id}',[InvoiceItemController::class,'update']);
Route::delete('/deleteInvoiceItems/{id}',[InvoiceItemController::class,'delete']);

//les routes pour le modele Payment
Route::get('/listPayment',[PaymentController::class,'index']);
Route::post('/AddPayments',[PaymentController::class,'create']);
Route::put('/updatePayments/{id}',[PaymentController::class,'update']);
Route::delete('/deletePayments/{id}',[PaymentController::class,'delete']);

//les routes pour le modele Role
Route::get('/listRole',[RoleController::class,'index']);
Route::post('/AddRoles',[RoleController::class,'create']);
Route::put('/updateRoles/{id}',[RoleController::class,'update']);
Route::delete('/deleteRoles/{id}',[RoleController::class,'delete']);

Route::get('/invoices-with-client-info', [InvoiceController::class, 'getInvoicesWithClientInfo']);
Route::get('/products-with-category-info', [ProductController::class, 'getProductsWithCategoryInfo']);
Route::get('/Invoice-Invoice_item-ClientInfo', [InvoiceController::class, 'getInvoiceInvoice_itemClientInfo']);

//login 
Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('logout', [LoginController::class, 'logout']);

























