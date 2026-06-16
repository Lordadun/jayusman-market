<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\StockMutation;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'owner') {
            $totalBranches = Branch::count();
            $totalProducts = Product::count();
            $todayTransactions = Transaction::whereDate('transaction_date', today())->count();
            $todayIncome = Transaction::whereDate('transaction_date', today())->sum('total_price');
            $lowStocks = Product::whereColumn('stock', '<=', 'min_stock')->with('branch')->get();
        } else {
            $totalBranches = 1;
            $totalProducts = Product::where('branch_id', $user->branch_id)->count();
            $todayTransactions = Transaction::where('branch_id', $user->branch_id)
                ->whereDate('transaction_date', today())
                ->count();

            $todayIncome = Transaction::where('branch_id', $user->branch_id)
                ->whereDate('transaction_date', today())
                ->sum('total_price');

            $lowStocks = Product::where('branch_id', $user->branch_id)
                ->whereColumn('stock', '<=', 'min_stock')
                ->get();
        }

        return view('dashboard', compact(
            'totalBranches',
            'totalProducts',
            'todayTransactions',
            'todayIncome',
            'lowStocks'
        ));
    }
}
