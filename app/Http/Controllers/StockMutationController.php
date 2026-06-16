<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMutationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $mutations = StockMutation::with(['branch', 'product', 'user'])
            ->when($user->role !== 'owner', fn ($q) => $q->where('branch_id', $user->branch_id))
            ->when($request->type, fn ($q) => $q->where('type', $request->type))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('stock_mutations.index', compact('mutations'));
    }

    public function create()
    {
        $user = auth()->user();
        $products = Product::with(['branch', 'category'])
            ->when($user->role !== 'owner', fn ($q) => $q->where('branch_id', $user->branch_id))
            ->orderBy('name')
            ->get();

        return view('stock_mutations.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = auth()->user();
            $product = Product::lockForUpdate()->findOrFail($request->product_id);

            if ($user->role !== 'owner' && (int) $product->branch_id !== (int) $user->branch_id) {
                abort(403, 'Akses ditolak.');
            }

            $stockBefore = $product->stock;

            if ($request->type === 'in') {
                $stockAfter = $stockBefore + $request->quantity;
            } else {
                if ($stockBefore < $request->quantity) {
                    abort(400, 'Stok tidak mencukupi.');
                }
                $stockAfter = $stockBefore - $request->quantity;
            }

            $product->update(['stock' => $stockAfter]);

            StockMutation::create([
                'branch_id' => $product->branch_id,
                'product_id' => $product->id,
                'user_id' => $user->id,
                'type' => $request->type,
                'quantity' => $request->quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'description' => $request->description,
            ]);
        });

        return redirect()->route('stock-mutations.index')->with('success', 'Mutasi stok berhasil disimpan.');
    }
}
