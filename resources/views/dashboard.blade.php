@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Monitoring</h1>
        <p class="text-gray-500">Selamat datang, {{ auth()->user()->name }}</p>
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

    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Stok Hampir Habis</h2>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Produk</th>
                    <th class="p-3">Cabang</th>
                    <th class="p-3">Stok</th>
                    <th class="p-3">Minimum</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lowStocks as $product)
                    <tr class="border-b">
                        <td class="p-3">{{ $product->name }}</td>
                        <td class="p-3">{{ $product->branch->name ?? '-' }}</td>
                        <td class="p-3 text-red-600 font-bold">{{ $product->stock }}</td>
                        <td class="p-3">{{ $product->min_stock }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-3 text-center text-gray-500">
                            Tidak ada stok menipis.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection