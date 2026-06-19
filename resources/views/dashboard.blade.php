@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Monitoring</h1>
    <p class="text-gray-500">Ringkasan transaksi dan stok mini market.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Total Cabang</p>
        <h2 class="text-3xl font-bold text-blue-600">{{ $totalBranches }}</h2>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Total Produk</p>
        <h2 class="text-3xl font-bold text-green-600">{{ $totalProducts }}</h2>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Transaksi Hari Ini</p>
        <h2 class="text-3xl font-bold text-purple-600">{{ $todayTransactions }}</h2>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <p class="text-gray-500">Pendapatan Hari Ini</p>
        <h2 class="text-2xl font-bold text-orange-600">
            Rp {{ number_format($todayIncome, 0, ',', '.') }}
        </h2>
    </div>
</div>

<div class="bg-white rounded-2xl shadow p-6 mb-8">
 <div class="flex justify-between items-center mb-4">
 <div>
 <h2 class="text-xl font-semibold text-gray-800">Grafik Pendapatan Per Cabang</h2>
 <p class="text-gray-500 text-sm">
 Pendapatan dihitung dari total transaksi pada setiap cabang.
 </p>
 </div>
 </div>
 @forelse($branchIncomes as $branch)
 @php
 $income = $branch->total_income ?? 0;
 $percentage = ($income / $maxIncome) * 100;
 @endphp
 <div class="mb-5">
 <div class="flex justify-between mb-2">
 <div>
 <p class="font-semibold text-gray-800">{{ $branch->name }}</p>
 <p class="text-sm text-gray-500">{{ $branch->city }}</p>
 </div>
 <p class="font-bold text-blue-600">
 Rp {{ number_format($income, 0, ',', '.') }}
 </p>
 </div>
 <div class="w-full bg-gray-200 rounded-full h-5">
 <div
 class="bg-blue-600 h-5 rounded-full text-xs text-white text-center"
 style="width: {{ $percentage }}%">
 @if($percentage > 15)
 {{ round($percentage) }}%
 @endif
 </div>
 </div>
 </div>
 @empty
 <p class="text-gray-500">
 Belum ada data pendapatan cabang.
 </p>
 @endforelse
</div>


<div class="bg-white rounded-2xl shadow p-6 mb-8">
 <div class="flex justify-between items-center mb-4">
 <div>
 <h2 class="text-xl font-semibold text-gray-800">Produk Terlaris</h2>
 <p class="text-gray-500 text-sm">Produk yang paling banyak terjual berdasarkan transaksi.</p>
 </div>
 </div>
 <div class="overflow-x-auto">
 <table class="w-full">
 <thead class="bg-gray-100 text-left">
 <tr>
 <th class="p-3">Peringkat</th>
 <th class="p-3">Nama Produk</th>
 <th class="p-3">Total Terjual</th>
 <th class="p-3">Total Pendapatan</th>
 <th class="p-3">Status</th>
 </tr>
 </thead>
 <tbody>
 @forelse($bestSellingProducts as $index => $item)
 <tr class="border-b">
 <td class="p-3">
 <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
 #{{ $index + 1 }}
 </span>
 </td>
 <td class="p-3 font-semibold">
 {{ $item->product->name ?? 'Produk tidak ditemukan' }}
 </td>
 <td class="p-3">
 {{ $item->total_sold }} pcs
 </td>
 <td class="p-3">
 Rp {{ number_format($item->total_income, 0, ',', '.') }}
 </td>
 <td class="p-3">
 @if($index == 0)
 <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
 Paling Laris
 </span>
 @else
 <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
 Terjual
 </span>
 @endif
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="5" class="p-4 text-center text-gray-500">
 Belum ada data produk terjual.
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
</div>

<div class="bg-white rounded-2xl shadow p-6">
    <h2 class="text-xl font-semibold mb-4">Stok Hampir Habis</h2>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">Produk</th>
                <th class="p-3">Cabang</th>
                <th class="p-3">Stok</th>
                <th class="p-3">Minimum</th>
                <th class="p-3">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lowStocks as $product)
                <tr class="border-b">
                    <td class="p-3">{{ $product->name }}</td>
                    <td class="p-3">{{ $product->branch->name ?? '-' }}</td>
                    <td class="p-3">{{ $product->stock }}</td>
                    <td class="p-3">{{ $product->min_stock }}</td>
                    <td class="p-3">
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                            Stok Menipis
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-3 text-center text-gray-500">
                        Tidak ada stok menipis.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection