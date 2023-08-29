<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoiceArechieveController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

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

Auth::routes();
// Auth::routes(['register'=> false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/invoices', [App\Http\Controllers\InvoicesController::class, 'index'])->name('invoices');
Route::get('/invoices/create', [App\Http\Controllers\InvoicesController::class, 'create']);
Route::post('/invoices/store', [App\Http\Controllers\InvoicesController::class, 'store']);
Route::patch('/invoices/update', [App\Http\Controllers\InvoicesController::class, 'update']);
Route::delete('/invoices/destroy', [App\Http\Controllers\InvoicesController::class, 'destroy'])->name('invoices.destroy');
Route::get('Invoice_Paid', [App\Http\Controllers\InvoicesController::class, 'getPaidInvoices']);
Route::get('Invoice_unPaid', [App\Http\Controllers\InvoicesController::class, 'getUnpaidInvoices']);
Route::get('Invoice_PartialPaid', [App\Http\Controllers\InvoicesController::class, 'getPartialPaidInvoices']);
Route::get('/section/{id}', [App\Http\Controllers\InvoicesController::class, 'getproducts']);
Route::get('/edit_invoice/{id}', [App\Http\Controllers\InvoicesController::class, 'edit']);
Route::get('/Status_show/{id}', [App\Http\Controllers\InvoicesController::class, 'show'])->name('Status_show');
Route::post('/Status_Update/{id}', [App\Http\Controllers\InvoicesController::class, 'Status_Update'])->name('Status_Update');
Route::get('Print_invoice/{id}', [App\Http\Controllers\InvoicesController::class, 'Print_invoice']);
Route::get('/InvoicesDetails/{id}', [App\Http\Controllers\InvoicesDetailsController::class, 'edit']);
Route::resource('Archive', InvoiceArechieveController::class);
Route::get('/download/{invoice_number}/{file_name}', [App\Http\Controllers\InvoicesDetailsController::class, 'get_file']);
Route::get('/View_file/{invoice_number}/{file_name}', [App\Http\Controllers\InvoicesDetailsController::class, 'open_file']);
Route::post('/delete_file', [App\Http\Controllers\InvoicesDetailsController::class, 'destroy'])->name('delete_file');
Route::resource('InvoiceAttachments', InvoicesAttachmentsController::class);

// Route::get('/sections', [App\Http\Controllers\SectionsController::class, 'index'])->name('sections');
Route::resource('sections', SectionsController::class);
Route::resource('products', ProductsController::class);
Route::get('/{page}', [AdminController::class, 'index']);
Route::group(['middleware' => ['auth']], function () {


    Route::get('users/show_users', [UserController::class,'index']);
    Route::get('users/edit', [UserController::class,'edit'])->name('users.edit');
    Route::get('users/destroy', [UserController::class,'destroy'])->name('users.destroy');
    Route::get('roles/index', [RoleController::class,'index']);
    Route::get('roles/edit', [RoleController::class,'edit'])->name('roles.edit');
    Route::get('roles/destroy', [RoleController::class,'destroy'])->name('roles.destroy');
    Route::get('roles/create', [RoleController::class,'destroy'])->name('roles.create');
});

