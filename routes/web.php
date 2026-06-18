<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StockMutationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditLogController;


Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:owner'])->group(function () {
        Route::resource('branches', BranchController::class);
        Route::resource('users', UserController::class);
    });

    Route::middleware(['role:owner,manager,supervisor,warehouse'])->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('stock-mutations', StockMutationController::class)->except(['show', 'edit', 'update']);
    });

    Route::middleware(['role:owner,manager,supervisor,cashier'])->group(function () {
        Route::resource('transactions', TransactionController::class)->except(['edit', 'update']);
    });

    Route::middleware(['role:owner,manager'])->group(function () {
        Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
        Route::get('/reports/stocks', [ReportController::class, 'stocks'])->name('reports.stocks');
        Route::get('/reports/transactions/print', [ReportController::class, 'printTransactions'])->name('reports.transactions.print');
        Route::get('/reports/stocks/print', [ReportController::class, 'printStocks'])->name('reports.stocks.print');
    });
    Route::get('/audit-logs', [AuditLogController::class, 'index'])
    ->name('audit-logs.index');
});


    

    
 
