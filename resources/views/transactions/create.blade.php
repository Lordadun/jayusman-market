@extends('layouts.app')
@section('title', 'Tambah Transaksi')
@section('content')
<h1 class="text-2xl font-bold mb-6">Tambah Transaksi</h1>
<form action="{{ route('transactions.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm max-w-4xl">@csrf
    <div id="items" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div><label class="block mb-1 font-medium">Produk</label><select name="products[0][product_id]" class="w-full border rounded-xl p-3" required>@foreach($products as $product)<option value="{{ $product->id }}">{{ $product->name }} - {{ $product->branch->name ?? '-' }} - Stok {{ $product->stock }} - Rp {{ number_format($product->selling_price,0,',','.') }}</option>@endforeach</select></div>
            <div><label class="block mb-1 font-medium">Jumlah</label><input type="number" name="products[0][quantity]" class="w-full border rounded-xl p-3" min="1" value="1" required></div>
        </div>
    </div>
    <div class="mt-4"><label class="block mb-1 font-medium">Uang Bayar</label><input type="number" name="paid_amount" class="w-full border rounded-xl p-3" min="0" required></div>
    <div class="flex gap-2 mt-6"><button class="bg-blue-600 text-white px-4 py-2 rounded-xl">Simpan Transaksi</button><a href="{{ route('transactions.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-xl">Kembali</a></div>
</form>
@endsection
