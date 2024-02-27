<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SaleController;

#redirect to create page
Route::get('', [SaleController::class, 'create'])->name('sales.create');
Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
#store data 
Route::post('/sales/store', [SaleController::class, 'store'])->name('sales.store');

#fetch sales details based on invoice number
Route::get('/sales-data', [SaleController::class, 'getSalesData']);
#ajax request to load products
Route::get('/get-product-details/{productId}', [SaleController::class, 'getProductDetails']);
#return view
Route::get('/datatable', [SaleController::class, 'datatable'])->name('sales.datatable');
#for ajax request
Route::get('/salesdata', [SaleController::class, 'getallsales'])->name('sales.index');

Route::put('/salesupdate/{id}', [SaleController::class, 'update'])->name('sales.update');

Route::get('/sales/{invoiceNumber}/edit', [SaleController::class, 'edit'])->name('sales.edit');

Route::get('/invoice/{invoiceNumber}', [SaleController::class, 'showInvoice'])->name('invoice.show');

