<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
 public function index()
 {
 $user = auth()->user();
 if ($user->role === 'owner') {
 $totalBranches = Branch::count();
 $totalProducts = Product::count();
 $todayTransactions = Transaction::whereDate('transaction_date', today())
 ->count();
 $todayIncome = Transaction::whereDate('transaction_date', today())
 ->sum('total_price');
 $lowStocks = Product::with('branch')
 ->whereColumn('stock', '<=', 'min_stock')
 ->get();
 // Grafik pendapatan semua cabang untuk owner
 $branchIncomes = Branch::withSum('transactions as total_income', 'total_price')
 ->get();
 } else {
 $totalBranches = 1;
 $totalProducts = Product::where('branch_id', $user->branch_id)
 ->count();
 $todayTransactions = Transaction::where('branch_id', $user->branch_id)
 ->whereDate('transaction_date', today())
 ->count();
 $todayIncome = Transaction::where('branch_id', $user->branch_id)
 ->whereDate('transaction_date', today())
 ->sum('total_price');
 $lowStocks = Product::with('branch')
 ->where('branch_id', $user->branch_id)
 ->whereColumn('stock', '<=', 'min_stock')
 ->get();
 // Selain owner hanya melihat pendapatan cabangnya sendiri
 $branchIncomes = Branch::where('id', $user->branch_id)
 ->withSum('transactions as total_income', 'total_price')
 ->get();
 }

 $bestSellingProducts = TransactionDetail::with('product')
    ->select(
        'product_id',
        DB::raw('SUM(quantity) as total_sold'),
        DB::raw('SUM(subtotal) as total_income')
    )
    ->groupBy('product_id')
    ->orderByDesc('total_sold')
    ->take(10)
    ->get();
 // Untuk menghitung panjang bar grafik
 $maxIncome = $branchIncomes->max('total_income') ?: 1;
 return view('dashboard', compact(
    'totalBranches',
    'totalProducts',
    'todayTransactions',
    'todayIncome',
    'lowStocks',
    'branchIncomes',
    'maxIncome',
    'bestSellingProducts'
    ));
 }

}