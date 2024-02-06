<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\BranchStockInvoiceController;
use App\Http\Controllers\BranchStockInvoiceDetailController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BranchSaleReturnMasterController;
use App\Http\Controllers\PricesController;
use App\Http\Controllers\ReportsController;
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
    return view('welcome');
});

Auth::routes();

/*** Barcode & POS */

Route::get('/barcode/verify/{id}',[PricesController::class,'verify_barcode'])->name('barcode.verify');
Route::post('/barcode/create_sale_list',[HomeController::class,'create_sale_list'])->name('barcode.create_sale_list');
Route::get('/barcode/print_label',[HomeController::class,'print_label'])->name('barcode.print_label');
Route::post('/barcode/get_print_label',[HomeController::class,'get_print_label'])->name('barcode.get_print_label');

/*** Sale */
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/home/add_product_sale', [HomeController::class, 'add_product_sale'])->name('home.add_product_sale');
Route::get('/home/get_sale_products/{id}', [HomeController::class, 'get_sale_products'])->name('home.get_sale_products');
Route::get('/home/remove_sale_products/{id}', [HomeController::class, 'remove_sale_products'])->name('home.remove_sale_products');
Route::get('/home/get_customer/{id}', [HomeController::class, 'get_customer'])->name('home.get_customer');
Route::get('/home/get_sale_ivoices', [HomeController::class, 'get_sale_ivoices'])->name('home.get_sale_ivoices');
Route::get('/home/get_sale_ivoice/{id}', [HomeController::class, 'get_sale_invoice'])->name('home.get_sale_invoice');

Route::post('/home/confirm_sale_inv', [HomeController::class, 'confirm_sale_inv'])->name('home.confirm_sale_inv');

/*** Sale Return */

Route::get('/sale/return',[BranchSaleReturnMasterController::class,'index'])->name('sale.sale_return');
Route::get('/sale/get_returns',[BranchSaleReturnMasterController::class,'get_returns'])->name('sale.get_sale_returns');
Route::get('/sale/get_return_view/{id}',[BranchSaleReturnMasterController::class,'get_return_view'])->name('sale.get_return_view');
Route::post('/sale/return/add_return_product',[BranchSaleReturnMasterController::class,'add_return_product'])->name('sale.add_return_product');
Route::get('/sale/get_return_products/{id}', [BranchSaleReturnMasterController::class, 'get_return_products'])->name('sale.get_return_products');
Route::get('/sale/remove_sale_return_products/{id}', [BranchSaleReturnMasterController::class, 'remove_sale_return_products'])->name('sale.remove_sale_return_products');
Route::post('/sale/confirm_sale_ret_inv', [BranchSaleReturnMasterController::class, 'confirm_sale_ret_inv'])->name('sale.confirm_sale_ret_inv');

/*** Categories */
Route::get('/categories',[CategoriesController::class,'index'])->name('categories');
Route::post('/categories/store',[CategoriesController::class,'store'])->name('categories.store');
Route::post('/categories/delete',[CategoriesController::class,'destroy'])->name('categories.delete');
Route::post('/categories/update',[CategoriesController::class,'update'])->name('categories.update');

/*** Products */
Route::get('/products',[ProductController::class,'index'])->name('products');
Route::get('/products/create',[ProductController::class,'create'])->name('products.create');
Route::post('/products/store',[ProductController::class,'store'])->name('products.store');
Route::get('/products/edit/{id}',[ProductController::class,'edit'])->name('products.edit');
Route::post('/products/update',[ProductController::class,'update'])->name('products.update');
Route::post('/products/delete',[ProductController::class,'destroy'])->name('products.delete');
Route::post('/products/restore',[ProductController::class,'restore'])->name('products.restore');

/*** Purchases */

Route::get('/purchases',[PurchaseController::class,'index'])->name('purchases');
Route::get('/purchases/create',[PurchaseController::class,'create'])->name('purchases.create');
Route::post('/purchases/store',[PurchaseController::class,'store'])->name('purchases.store');
Route::get('/purchases/getproducts/{id}',[PurchaseController::class,'getproducts'])->name('purchases.getproducts');
Route::get('/purchases/delete_row/{id}',[PurchaseController::class,'delete_row'])->name('purchases.delete_row');
Route::post('/purchases/confirm_status',[PurchaseController::class,'confirm_status'])->name('purchases.confirm_status');
Route::get('/purchases/show/{id}',[PurchaseController::class,'show'])->name('purchases.show');


/*** Stock */

Route::get('/stock',[StockController::class,'index'])->name('stock');
Route::post('/stock/stock_by_branch',[StockController::class,'show'])->name('stock.show');
Route::get('/stock/branch_stock/{id}',[StockController::class,'branch_stock'])->name('stock.branch_stock');
Route::post('/stock/get_stock_by_product',[StockController::class,'get_stock_by_product'])->name('stock.get_stock_by_product');

/*** Vendors */

Route::get('/vendors',[VendorController::class, 'index'])->name('vendors');
Route::get('/vendor/create',[VendorController::class,'create'])->name('vendors.create');
Route::get('/vendor/show/{id}',[VendorController::class,'show'])->name('vendors.show');
Route::get('/vendor/show_json/{id}',[VendorController::class,'show_json'])->name('vendors.show_json');
Route::get('/vendor/edit/{id}',[VendorController::class,'edit'])->name('vendors.edit');
Route::post('/vendor/update',[VendorController::class,'update'])->name('vendors.update');
Route::post('/vendor/store',[VendorController::class,'store'])->name('vendors.store');
Route::post('/vendor/delete',[VendorController::class,'destroy'])->name('vendors.delete');
Route::post('/vendor/restore',[VendorController::class,'restore'])->name('vendors.restore');

/*** Branches */

Route::get('/branches',[BranchesController::class,'index'])->name('branches');
Route::get('/branches/create',[BranchesController::class,'create'])->name('branches.create');
Route::post('/branches/store',[BranchesController::class,'store'])->name('branches.store');
Route::get('/branches/edit/{id}',[BranchesController::class,'edit'])->name('branches.edit');
Route::get('/branches/show/{id}',[BranchesController::class,'show'])->name('branches.show');
Route::get('/branches/show_json/{id}',[BranchesController::class,'show_json'])->name('branches.show_json');
Route::post('/branches/update',[BranchesController::class,'update'])->name('branches.update');
Route::post('/branches/delete',[BranchesController::class,'destroy'])->name('branches.delete');
Route::post('/branches/restore',[BranchesController::class,'restore'])->name('branches.restore');

/*** Branch Users */
Route::get('/branches/branch_user_list',[BranchesController::class,'branch_user_list'])->name('branches.branch_user_list');
Route::get('/branches/create_branch_user',[BranchesController::class,'create_branch_user'])->name('branches.create_branch_user');
Route::post('/branches/store_branch_user',[BranchesController::class,'store_branch_user'])->name('branches.store_branch_user');
Route::post('/branches/delete_branch_user',[BranchesController::class,'delete_branch_user'])->name('branches.delete_branch_user');
Route::post('/branches/restore_branch_user',[BranchesController::class,'restore_branch_user'])->name('branches.restore_branch_user');
Route::get('/branches/edit_branch_user/{id}',[BranchesController::class,'edit_branch_user'])->name('branches.edit_branch_user');
Route::post('/branches/update_branch_user',[BranchesController::class,'update_branch_user'])->name('branches.update_branch_user');
/*** Others */

Route::get('/getsizes/{id}',[ProductController::class,'getsizes'])->name('getsizes');
Route::get('/getpurprices/{id}',[ProductController::class,'getpurprices'])->name('getpurprices');
Route::get('/getsalesizes/{id}',[ProductController::class,'getsalesizes'])->name('getsalesizes');

Route::get('/getsaleprices/{id}',[ProductController::class,'getsaleprices'])->name('getsaleprices');

/** Ledger */

Route::get('/journal/payments',[LedgerController::class,'index'])->name('ledger.payments');
Route::get('/journal/payments/create/{id}',[LedgerController::class,'create'])->name('ledger.create');
Route::post('/journal/payments/pay_to_vendor',[LedgerController::class,'pay_to_vendor'])->name('ledger.pay_to_vendor');
Route::post('/journal/payments/branch_to_bank',[LedgerController::class,'branch_to_bank'])->name('ledger.branch_to_bank');
Route::post('/journal/payments/bank_to_bank',[LedgerController::class,'bank_to_bank'])->name('ledger.bank_to_bank');
Route::post('/journal/payments/branch_to_mainstore',[LedgerController::class,'branch_to_mainstore'])->name('ledger.branch_to_mainstore');
Route::get('/journal/payments/sale_json',[LedgerController::class,'sale_json'])->name('ledger.sale_json');
Route::post('/journal/payments/sale_to_bank',[LedgerController::class,'sale_to_bank'])->name('ledger.sale_to_bank');

/** Banks */
Route::get('/banks',[BanksController::class, 'index'])->name('banks');
Route::get('/banks/json/{id}',[BanksController::class, 'index_json'])->name('banks.index_json');
Route::get('/banks/create',[BanksController::class,'create'])->name('banks.create');
Route::get('/banks/show/{id}',[BanksController::class,'show'])->name('banks.show');
Route::get('/banks/show_json/{id}',[BanksController::class,'show_json'])->name('banks.show_json');
Route::get('/banks/edit/{id}',[BanksController::class,'edit'])->name('banks.edit');
Route::post('/banks/update',[BanksController::class,'update'])->name('banks.update');
Route::post('/banks/store',[BanksController::class,'store'])->name('banks.store');
Route::post('/banks/delete',[BanksController::class,'destroy'])->name('banks.delete');
Route::post('/banks/restore',[BanksController::class,'restore'])->name('banks.restore');

/** Branch Stock Invoice */

Route::get('/stock_invoice',[BranchStockInvoiceController::class,'index'])->name('stock_invoice.index');
Route::get('/stock_invoice/create',[BranchStockInvoiceController::class,'create'])->name('stock_invoice.create');
Route::post('/stock_invoice/confirm_status',[BranchStockInvoiceController::class,'confirm_status'])->name('stock_invoice.confirm_status');
Route::get('/stock_invoice/show/{id}',[BranchStockInvoiceController::class,'show'])->name('stock_invoice.show');

/** Stock invoice Detail */
Route::post('/stock_invoice_detail/store',[BranchStockInvoiceDetailController::class,'store'])->name('stock_invoice_detail.store');
Route::get('/stock_invoice_detail/getproducts/{id}',[BranchStockInvoiceDetailController::class,'getproducts'])->name('stock_invoice_detail.getproducts');
Route::get('/stock_invoice_detail/delete_row/{id}',[BranchStockInvoiceDetailController::class,'delete_row'])->name('stock_invoice_detail.delete_row');
Route::post('/stock_invoice/confirm_stock_receving',[BranchStockInvoiceDetailController::class,'confirm_stock_receving'])->name('stock_invoice_detail.confirm_stock_receving');

/** Customers */
Route::get('/customers',[CustomerController::class,'index'])->name('customers');
Route::get('/customers/create',[CustomerController::class,'create'])->name('customers.create');
Route::get('/customers/show/{id}',[CustomerController::class,'show'])->name('customers.show');
Route::post('/customers/store',[CustomerController::class,'store'])->name('customers.store');
Route::post('/customers/delete',[CustomerController::class,'destroy'])->name('customers.delete');
Route::post('/customers/restore',[CustomerController::class,'restore'])->name('customers.restore');
Route::get('/customers/edit/{id}',[CustomerController::class,'edit'])->name('customers.edit');
Route::post('/customers/update',[CustomerController::class,'update'])->name('customers.update');

/** Reports */
Route::get('/reports/payment_report',[ReportsController::class,'payment_report'])->name('reports.payment_report');
Route::post('/reports/get_payment_report',[ReportsController::class,'get_payment_report'])->name('reports.get_payment_report');
Route::get('/reports/sale_report',[ReportsController::class,'sale_report'])->name('reports.sale_report');
Route::post('/reports/get_sale_report',[ReportsController::class,'get_sale_report'])->name('reports.get_sale_report');
Route::get('/reports/sale_return_report',[ReportsController::class,'sale_return_report'])->name('reports.sale_return_report');
Route::post('/reports/get_sale_return_report',[ReportsController::class,'get_sale_return_report'])->name('reports.get_sale_return_report');
Route::get('/reports/purchase_report',[ReportsController::class,'purchase_report'])->name('reports.purchase_report');
Route::post('/reports/get_purchase_report',[ReportsController::class,'get_purchase_report'])->name('reports.get_purchase_report');
Route::get('/reports/customer_report',[ReportsController::class,'customer_report'])->name('reports.customer_report');
Route::post('/reports/get_customer_report',[ReportsController::class,'get_customer_report'])->name('reports.get_customer_report');