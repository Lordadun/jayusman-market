<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\StockMutation;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $productQuery = Product::query();
        $transactionQuery = Transaction::query();
        $mutationQuery = StockMutation::query();

        if ($user->role !== 'owner') {
            $productQuery->where('branch_id', $user->branch_id);
            $transactionQuery->where('branch_id', $user->branch_id);
            $mutationQuery->where('branch_id', $user->branch_id);
        }

        $totalBranches = $user->role === 'owner' ? Branch::count() : 1;
        $totalProducts = (clone $productQuery)->count();
        $todayTransactions = (clone $transactionQuery)->whereDate('transaction_date', today())->count();
        $todayIncome = (clone $transactionQuery)->whereDate('transaction_date', today())->sum('total_price');
        $lowStocks = (clone $productQuery)->with(['branch','category'])->whereColumn('stock', '<=', 'min_stock')->limit(10)->get();
        $latestTransactions = (clone $transactionQuery)->with(['branch','cashier'])->latest()->limit(5)->get();
        $latestMutations = (clone $mutationQuery)->with(['branch','product','user'])->latest()->limit(5)->get();

        return view('dashboard.index', compact(
            'totalBranches',
            'totalProducts',
            'todayTransactions',
            'todayIncome',
            'lowStocks',
            'latestTransactions',
            'latestMutations'
        ));
    }
}
