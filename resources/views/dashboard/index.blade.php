@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold">Dashboard Monitoring</h1>
    <p class="text-gray-500">Ringkasan transaksi, stok, dan aktivitas cabang.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
    <div class="bg-white p-6 rounded-2xl shadow-sm"><p class="text-gray-500">Total Cabang</p><h2 class="text-3xl font-bold text-blue-600">{{ $totalBranches }}</h2></div>
    <div class="bg-white p-6 rounded-2xl shadow-sm"><p class="text-gray-500">Total Produk</p><h2 class="text-3xl font-bold text-green-600">{{ $totalProducts }}</h2></div>
    <div class="bg-white p-6 rounded-2xl shadow-sm"><p class="text-gray-500">Transaksi Hari Ini</p><h2 class="text-3xl font-bold text-purple-600">{{ $todayTransactions }}</h2></div>
    <div class="bg-white p-6 rounded-2xl shadow-sm"><p class="text-gray-500">Pendapatan Hari Ini</p><h2 class="text-2xl font-bold text-orange-600">Rp {{ number_format($todayIncome,0,',','.') }}</h2></div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm p-6 overflow-x-auto">
        <h2 class="text-lg font-bold mb-4">Stok Hampir Habis</h2>
        <table class="w-full text-sm">
            <thead class="bg-gray-100"><tr><th class="p-3 text-left">Produk</th><th class="p-3 text-left">Cabang</th><th class="p-3">Stok</th><th class="p-3">Min</th></tr></thead>
            <tbody>
                @forelse($lowStocks as $product)
                <tr class="border-b"><td class="p-3">{{ $product->name }}</td><td class="p-3">{{ $product->branch->name ?? '-' }}</td><td class="p-3 text-center text-red-600 font-bold">{{ $product->stock }}</td><td class="p-3 text-center">{{ $product->min_stock }}</td></tr>
                @empty
                <tr><td colspan="4" class="p-3 text-center text-gray-500">Tidak ada stok menipis.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 overflow-x-auto">
        <h2 class="text-lg font-bold mb-4">Transaksi Terbaru</h2>
        <table class="w-full text-sm">
            <thead class="bg-gray-100"><tr><th class="p-3 text-left">Invoice</th><th class="p-3 text-left">Cabang</th><th class="p-3 text-right">Total</th></tr></thead>
            <tbody>
                @forelse($latestTransactions as $trx)
                <tr class="border-b"><td class="p-3">{{ $trx->invoice_number }}</td><td class="p-3">{{ $trx->branch->name ?? '-' }}</td><td class="p-3 text-right">Rp {{ number_format($trx->total_price,0,',','.') }}</td></tr>
                @empty
                <tr><td colspan="3" class="p-3 text-center text-gray-500">Belum ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
