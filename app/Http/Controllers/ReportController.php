<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transactions(Request $request)
    {
        $transactions = $this->transactionQuery($request)->get();
        return view('reports.transactions', compact('transactions'));
    }

    public function printTransactions(Request $request)
    {
        $transactions = $this->transactionQuery($request)->get();
        return view('reports.transactions_print', compact('transactions'));
    }

    public function stocks(Request $request)
    {
        $products = $this->stockQuery($request)->get();
        return view('reports.stocks', compact('products'));
    }

    public function printStocks(Request $request)
    {
        $products = $this->stockQuery($request)->get();
        return view('reports.stocks_print', compact('products'));
    }

    private function transactionQuery(Request $request)
    {
        $user = auth()->user();

        return Transaction::with(['branch', 'cashier'])
            ->when($user->role !== 'owner', fn ($q) => $q->where('branch_id', $user->branch_id))
            ->when($request->start_date, fn ($q) => $q->whereDate('transaction_date', '>=', $request->start_date))
            ->when($request->end_date, fn ($q) => $q->whereDate('transaction_date', '<=', $request->end_date))
            ->latest();
    }

    private function stockQuery(Request $request)
    {
        $user = auth()->user();

        return Product::with(['branch', 'category'])
            ->when($user->role !== 'owner', fn ($q) => $q->where('branch_id', $user->branch_id))
            ->when($request->status === 'low', fn ($q) => $q->whereColumn('stock', '<=', 'min_stock'))
            ->orderBy('name');
    }
}
