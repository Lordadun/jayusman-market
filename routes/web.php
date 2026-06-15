<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StockMutationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:owner'])->group(function () {
        Route::resource('branches', BranchController::class);
        Route::resource('users', UserController::class);
    });

    Route::middleware(['role:owner,manager,supervisor,warehouse'])->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('stock-mutations', StockMutationController::class);
    });

    Route::middleware(['role:owner,manager,supervisor,cashier'])->group(function () {
        Route::resource('transactions', TransactionController::class);
    });

    Route::middleware(['role:owner,manager'])->group(function () {
        Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
        Route::get('/reports/stocks', [ReportController::class, 'stocks'])->name('reports.stocks');
        Route::get('/reports/transactions/print', [ReportController::class, 'printTransactions'])->name('reports.transactions.print');
        Route::get('/reports/stocks/print', [ReportController::class, 'printStocks'])->name('reports.stocks.print');
    });
});


require __DIR__.'/auth.php';