<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\StockMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $transactions = Transaction::with(['branch', 'cashier'])
            ->when($user->role !== 'owner', fn ($q) => $q->where('branch_id', $user->branch_id))
            ->when($request->start_date, fn ($q) => $q->whereDate('transaction_date', '>=', $request->start_date))
            ->when($request->end_date, fn ($q) => $q->whereDate('transaction_date', '<=', $request->end_date))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $user = auth()->user();

        $products = Product::with(['branch', 'category'])
            ->where('stock', '>', 0)
            ->when($user->role !== 'owner', fn ($q) => $q->where('branch_id', $user->branch_id))
            ->orderBy('name')
            ->get();

        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $user = auth()->user();
            $totalPrice = 0;
            $branchId = null;

            foreach ($request->products as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                if ($user->role !== 'owner' && (int) $product->branch_id !== (int) $user->branch_id) {
                    abort(403, 'Produk bukan milik cabang Anda.');
                }

                if ($branchId === null) {
                    $branchId = $product->branch_id;
                }

                if ((int) $product->branch_id !== (int) $branchId) {
                    return back()->with('error', 'Satu transaksi hanya boleh berisi produk dari cabang yang sama.');
                }

                if ($product->stock < $item['quantity']) {
                    return back()->with('error', 'Stok produk ' . $product->name . ' tidak mencukupi.');
                }

                $totalPrice += $product->selling_price * $item['quantity'];
            }

            if ($request->paid_amount < $totalPrice) {
                return back()->with('error', 'Uang pembayaran kurang.');
            }

            $transaction = Transaction::create([
                'branch_id' => $branchId,
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . now()->format('YmdHis') . '-' . $user->id,
                'total_price' => $totalPrice,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $request->paid_amount - $totalPrice,
                'transaction_date' => now()->toDateString(),
            ]);

            foreach ($request->products as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);
                $stockBefore = $product->stock;
                $stockAfter = $stockBefore - $item['quantity'];

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->selling_price,
                    'subtotal' => $product->selling_price * $item['quantity'],
                ]);

                $product->update(['stock' => $stockAfter]);

                StockMutation::create([
                    'branch_id' => $product->branch_id,
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,
                    'description' => 'Stok keluar dari transaksi ' . $transaction->invoice_number,
                ]);
            }

            DB::commit();
            return redirect()->route('transactions.show', $transaction)->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
            }
    }

    public function show(Transaction $transaction)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && (int) $transaction->branch_id !== (int) $user->branch_id) {
            abort(403, 'Akses ditolak.');
        }

        $transaction->load(['branch', 'cashier', 'details.product']);
        return view('transactions.show', compact('transaction'));
    }

    public function receipt(Transaction $transaction)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && $transaction->branch_id !== $user->branch_id) {
        abort(403, 'Akses ditolak.');
        }
        $transaction->load([
        'branch',
        'cashier',
        'details.product'
        ]);
        return view('transactions.receipt', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        // Untuk menjaga audit stok, transaksi tidak benar-benar dihapus dari sistem.
        return redirect()->route('transactions.index')->with('error', 'Transaksi tidak dapat dihapus agar riwayat stok tetap valid.');
    }
}
