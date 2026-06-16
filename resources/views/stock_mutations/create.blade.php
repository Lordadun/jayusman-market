@extends('layouts.app')
@section('title', 'Tambah Mutasi Stok')
@section('content')
<h1 class="text-2xl font-bold mb-6">Tambah Mutasi Stok</h1>
<form action="{{ route('stock-mutations.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm max-w-4xl space-y-4">@csrf
    <div><label class="block mb-1 font-medium">Produk</label><select name="product_id" class="w-full border rounded-xl p-3" required>@foreach($products as $product)<option value="{{ $product->id }}">{{ $product->name }} - {{ $product->branch->name ?? '-' }} - Stok {{ $product->stock }}</option>@endforeach</select></div>
    <div><label class="block mb-1 font-medium">Tipe Mutasi</label><select name="type" class="w-full border rounded-xl p-3" required><option value="in">Barang Masuk</option><option value="out">Barang Keluar</option></select></div>
    <div><label class="block mb-1 font-medium">Jumlah</label><input type="number" name="quantity" class="w-full border rounded-xl p-3" min="1" required></div>
    <div><label class="block mb-1 font-medium">Keterangan</label><textarea name="description" class="w-full border rounded-xl p-3" placeholder="Contoh: Restock dari supplier / barang rusak"></textarea></div>
    <div class="flex gap-2"><button class="bg-blue-600 text-white px-4 py-2 rounded-xl">Simpan</button><a href="{{ route('stock-mutations.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-xl">Kembali</a></div>
</form>
@endsection
