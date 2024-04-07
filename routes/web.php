<?php

use App\Http\Controllers\ArchiveInvoicesController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Our resource routes
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
});
require __DIR__.'/auth.php';
//Route::fallback(fn()=> redirect('/invoices'));

Route::resource('invoices',InvoiceController::class);
Route::resource('ArchiveInvoices',ArchiveInvoicesController::class);
Route::resource('sections',SectionController::class);
Route::resource('products',ProductController::class);
    
    Route::get('invoice_details/{invoice_id}','InvoiceDetailController@index')->name('invoice.details');
    Route::get('paid_invoices',[InvoiceController::class,'paid_invoices']);
    Route::get('unpaid_invoices',[InvoiceController::class,'unpaid_invoices']);
    Route::get('partial_paid_invoices',[InvoiceController::class,'partial_paid_invoices']);
    Route::get('editInvoice/{invoice_id}',[InvoiceController::class,'edit'])->name('invoices.edit');
    Route::get('show_Status/{invoice_id}',[InvoiceController::class,'show'])->name('invoices.show');
    Route::post('change_Status',[InvoiceController::class,'changeStatus'])->name('invoices.changeStatus');
    Route::post('updateInvoice',[InvoiceController::class,'update'])->name('invoices.update');
    Route::get('print_invoice/{invoice_id}',[InvoiceController::class,'print_invoice']);
    Route::get('deleteAttachment/{atta_id}',[InvoiceController::class,'deleteAttachment']);
    Route::get('/section/{id}',[InvoiceController::class,'getProducts']);
    Route::get('export/Excel', [InvoiceController::class, 'export']);


Route::get('view_file/{folder_name}/{file_name}',[InvoiceDetailController::class,'show']);
Route::get('download_file/{folder_name}/{file_name}',[InvoiceDetailController::class,'download_file']);
Route::post('delete',[InvoiceDetailController::class,'destroy'])->name('files.destroy');


Route::get('/tabs',function(){
    return view('notification');
});