<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $products = Product::with(['branch', 'category'])
            ->when($user->role !== 'owner', fn ($q) => $q->where('branch_id', $user->branch_id))
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('code', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $user = auth()->user();
        $branches = $user->role === 'owner' ? Branch::all() : Branch::where('id', $user->branch_id)->get();
        $categories = Category::all();

        return view('products.create', compact('branches', 'categories'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:100|unique:products,code',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:30',
        ]);

        if ($user->role !== 'owner' && (int) $request->branch_id !== (int) $user->branch_id) {
            abort(403, 'Akses ditolak. Produk harus sesuai cabang Anda.');
        }

        Product::create($request->only([
            'branch_id', 'category_id', 'code', 'name', 'stock', 'min_stock', 'purchase_price', 'selling_price', 'unit'
        ]));

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product)
    {
        return redirect()->route('products.edit', $product);
    }

    public function edit(Product $product)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && (int) $product->branch_id !== (int) $user->branch_id) {
            abort(403, 'Akses ditolak.');
        }

        $branches = $user->role === 'owner' ? Branch::all() : Branch::where('id', $user->branch_id)->get();
        $categories = Category::all();

        return view('products.edit', compact('product', 'branches', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && (int) $product->branch_id !== (int) $user->branch_id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:100|unique:products,code,' . $product->id,
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:30',
        ]);

        if ($user->role !== 'owner' && (int) $request->branch_id !== (int) $user->branch_id) {
            abort(403, 'Akses ditolak. Produk harus sesuai cabang Anda.');
        }

        $product->update($request->only([
            'branch_id', 'category_id', 'code', 'name', 'stock', 'min_stock', 'purchase_price', 'selling_price', 'unit'
        ]));

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $user = auth()->user();
        if ($user->role !== 'owner' && (int) $product->branch_id !== (int) $user->branch_id) {
            abort(403, 'Akses ditolak.');
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
