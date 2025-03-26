<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\SupplierController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\PaySalaryController;
use App\Http\Controllers\Dashboard\AttendenceController;
use App\Http\Controllers\Dashboard\AdvanceSalaryController;
use App\Http\Controllers\Dashboard\DatabaseBackupController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\PosController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\SalesController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\TransactionController;
use App\Http\Controllers\Dashboard\InventoryController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\SettingsController;





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


// DEFAULT DASHBOARD & PROFILE

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::get('/sales-chart', [SalesController::class, 'showSalesChart']);
    Route::get('/dashboard/sales-revenue', [DashboardController::class, 'getSalesRevenueData'])->name('dashboard.sales_revenue');
    Route::get('/dashboard/sales-revenue', [DashboardController::class, 'getSalesRevenueData']);



    // ====== USERS ====

    Route::resource('/users', UserController::class)->except(['show']);

    // ====== CUSTOMERS ======

    Route::resource('/customers', CustomerController::class);

    // ====== SUPPLIERS ======

    Route::resource('/suppliers', SupplierController::class);
    
    // ====== SALES ========

    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    //===================REPORTS===================

    // Route for Reports Main Page
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Route for Product Report
    Route::get('/reports/products', [ReportController::class, 'products'])->name('reports.products');

    // Route for Sales Report
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/sales/export', [ReportController::class, 'exportSales'])->name('sales.exportData');


    // Route for Stock Report
    Route::get('/reports/stock', [ReportController::class, 'stockReport'])->name('reports.stock');

    // Route for Income
    Route::get('/income-report', [ReportController::class, 'incomeReport'])->name('reports.income');

    //============Inventory===============

    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    
    

Route::post('/inventory/stock-in', [InventoryController::class, 'stockIn'])->name('inventory.stock-in');
Route::get('/inventory/{product}/history', [InventoryController::class, 'stockInHistory'])->name('products.stock-in-history');
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');




    // ====== PRODUCTS ======
    Route::get('/lowStockProducts', [ProductController::class, 'lowStockProducts'])->name('products.lowStockProducts');
    Route::get('/products/import', [ProductController::class, 'importView'])->name('products.importView');
    Route::post('/products/import', [ProductController::class, 'importStore'])->name('products.importStore');
    Route::get('/products/export', [ProductController::class, 'exportData'])->name('products.exportData');
    Route::resource('/products', ProductController::class);
    ///modal
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products/stock-in', [ProductController::class, 'stockIn'])->name('products.stock-in');
    Route::post('/products/stock-in', [ProductController::class, 'stockIn'])->name('products.stock-in');

    Route::get('/products/{product}/stock-in-history', [ProductController::class, 'stockInHistory'])->name('products.stock-in-history');
    Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');


//////////////////NOTIFICATION


Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');


    
   

    // ====== CATEGORY PRODUCTS ======
    Route::resource('/categories', CategoryController::class);

    // ====== POS ======
    Route::get('/pos', [PosController::class,'index'])->name('pos.index');
    Route::post('/pos/add', [PosController::class, 'addCart'])->name('pos.addCart');
    Route::post('/pos/update/{rowId}', [PosController::class, 'updateCart'])->name('pos.updateCart');
    Route::get('/pos/delete/{rowId}', [PosController::class, 'deleteCart'])->name('pos.deleteCart');
    Route::post('/pos/invoice/create', [PosController::class, 'createInvoice'])->name('pos.createInvoice');  // create invoce view before pending.. after create button on pos//
    Route::post('/pos/invoice/print', [PosController::class, 'printInvoice'])->name('pos.printInvoice');
    Route::post('/pos/store-order', [PosController::class, 'storeOrder'])->name('pos.storeOrder');



    // Create Order
    Route::post('/pos/order', [OrderController::class, 'storeOrder'])->name('pos.storeOrder');

    // ====== ORDERS ======
    Route::get('/orders/complete', [OrderController::class, 'completeOrders'])->name('order.completeOrders');
    Route::get('/orders/details/{order_id}', [OrderController::class, 'orderDetails'])->name('order.orderDetails');
    Route::get('/orders/{id}/details', [OrderController::class, 'getOrderDetails']);

    Route::get('/invoice/{order_id}', [OrderController::class, 'showInvoice'])->name('invoice.show');
    Route::get('/orders/invoice/download/{order_id}', [OrderController::class, 'invoiceDownload'])->name('order.invoiceDownload');
    Route::get('/orders/{id}', [OrderController::class, 'getOrderDetails']);
    Route::put('/order/update-status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    

    // Pending Due
    // Route::get('/pending/due', [OrderController::class, 'pendingDue'])->name('order.pendingDue');
    // Route::get('/order/due/{id}', [OrderController::class, 'orderDueAjax'])->name('order.orderDueAjax');
    // Route::post('/update/due', [OrderController::class, 'updateDue'])->name('order.updateDue');

    // Stock Management
    Route::get('/stock', [OrderController::class, 'stockManage'])->name('order.stockManage');

    // // ====== DATABASE BACKUP ======
    // Route::get('/database/backup', [DatabaseBackupController::class, 'index'])->name('backup.index');
    // Route::get('/database/backup/now', [DatabaseBackupController::class, 'create'])->name('backup.create');
    // Route::get('/database/backup/download/{getFileName}', [DatabaseBackupController::class, 'download'])->name('backup.download');
    // Route::get('/database/backup/delete/{getFileName}', [DatabaseBackupController::class, 'delete'])->name('backup.delete');
    // ====== DATABASE BACKUP ======
Route::get('/database/backup', [DatabaseBackupController::class, 'index'])->name('backup.index');
Route::get('/database/backup/now', [DatabaseBackupController::class, 'create'])->name('backup.create');
Route::get('/database/backup/download/{filename}', [DatabaseBackupController::class, 'download'])->name('backup.download');
Route::get('/database/backup/delete/{filename}', [DatabaseBackupController::class, 'delete'])->name('backup.delete');
Route::get('/database/download/{filename}', [DatabaseBackupController::class, 'download'])->name('database.download');
Route::get('/database/download/{filename}', [DatabaseBackupController::class, 'download'])->name('database.download');
Route::delete('/database/delete/{filename}', [DatabaseBackupController::class, 'delete'])->name('database.delete');
Route::delete('/database/delete/{filename}', [DatabaseBackupController::class, 'delete'])->name('backup.delete');

Route::get('/backup/create', [DatabaseBackupController::class, 'create'])->name('backup.create');

Route::get('/database-backups', [DatabaseBackupController::class, 'index'])->name('backup.index');


        //============= settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        

    // ====== ROLE CONTROLLER ======
    // Permissions
    Route::get('/permission', [RoleController::class, 'permissionIndex'])->name('permission.index');
    Route::get('/permission/create', [RoleController::class, 'permissionCreate'])->name('permission.create');
    Route::post('/permission', [RoleController::class, 'permissionStore'])->name('permission.store');
    Route::get('/permission/edit/{id}', [RoleController::class, 'permissionEdit'])->name('permission.edit');
    Route::put('/permission/{id}', [RoleController::class, 'permissionUpdate'])->name('permission.update');
    Route::delete('/permission/{id}', [RoleController::class, 'permissionDestroy'])->name('permission.destroy');

    // Roles
    Route::get('/role', [RoleController::class, 'roleIndex'])->name('role.index');
    Route::get('/role/create', [RoleController::class, 'roleCreate'])->name('role.create');
    Route::post('/role', [RoleController::class, 'roleStore'])->name('role.store');
    Route::get('/role/edit/{id}', [RoleController::class, 'roleEdit'])->name('role.edit');
    Route::put('/role/{id}', [RoleController::class, 'roleUpdate'])->name('role.update');
    Route::delete('/role/{id}', [RoleController::class, 'roleDestroy'])->name('role.destroy');

    // Role Permissions
    Route::get('/role/permission', [RoleController::class, 'rolePermissionIndex'])->name('rolePermission.index');
    Route::get('/role/permission/create', [RoleController::class, 'rolePermissionCreate'])->name('rolePermission.create');
    Route::post('/role/permission', [RoleController::class, 'rolePermissionStore'])->name('rolePermission.store');
    Route::get('/role/permission/{id}', [RoleController::class, 'rolePermissionEdit'])->name('rolePermission.edit');
    Route::put('/role/permission/{id}', [RoleController::class, 'rolePermissionUpdate'])->name('rolePermission.update');
    Route::delete('/role/permission/{id}', [RoleController::class, 'rolePermissionDestroy'])->name('rolePermission.destroy');

require __DIR__.'/auth.php';
