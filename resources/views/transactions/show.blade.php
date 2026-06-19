@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
 <div>
 <h1 class="text-2xl font-bold text-gray-800">Detail Transaksi</h1>
 <p class="text-gray-500">Invoice: {{ $transaction->invoice_number }}</p>
 </div>

 <div class="flex gap-2">
 <a href="{{ route('transactions.index') }}"
 class="bg-gray-500 text-white px-4 py-2 rounded-lg">
 Kembali
 </a>
 <a href="{{ route('transactions.receipt', $transaction) }}"
 target="_blank"
 class="bg-green-600 text-white px-4 py-2 rounded-lg">
 Cetak Struk
 </a>
 </div>

</div>
<div class="bg-white rounded-2xl shadow p-6 mb-6">
 <h2 class="text-lg font-semibold mb-4">Informasi Transaksi</h2>
 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
 <div>
 <p class="text-gray-500 text-sm">Cabang</p>
 <p class="font-semibold">{{ $transaction->branch->name ?? '-' }}</p>
 </div>

 <div>
 <p class="text-gray-500 text-sm">Kasir</p>
 <p class="font-semibold">{{ $transaction->cashier->name ?? '-' }}</p>
 </div>

 <div>
 <p class="text-gray-500 text-sm">Tanggal Transaksi</p>
 <p class="font-semibold">{{ $transaction->transaction_date }}</p>
 </div>

 <div>
 <p class="text-gray-500 text-sm">Waktu Input</p>
 <p class="font-semibold">{{ $transaction->created_at->format('d-m-Y H:i') }}</p>
 </div>

 </div>
</div>
<div class="bg-white rounded-2xl shadow overflow-hidden mb-6">
 <table class="w-full">
 <thead class="bg-gray-100 text-left">
 <tr>
 <th class="p-3">No</th>
 <th class="p-3">Produk</th>
 <th class="p-3">Qty</th>
 <th class="p-3">Harga</th>
 <th class="p-3">Subtotal</th>
 </tr>
 </thead>
 <tbody>

 @foreach($transaction->details as $detail)
 <tr class="border-b">
 <td class="p-3">{{ $loop->iteration }}</td>
 <td class="p-3">{{ $detail->product->name ?? '-' }}</td>
 <td class="p-3">{{ $detail->quantity }}</td>
 <td class="p-3">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
 <td class="p-3">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
 </tr>

 @endforeach
 </tbody>
 </table>
</div>
<div class="bg-white rounded-2xl shadow p-6 max-w-md ml-auto">
 <div class="flex justify-between mb-3">
 <span>Total Belanja</span>
 <strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong>
 </div>
 <div class="flex justify-between mb-3">
 <span>Uang Bayar</span>
 <strong>Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</strong>
 </div>
 <div class="flex justify-between border-t pt-3">
 <span>Kembalian</span>
 <strong>Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</strong>
 </div>
 
</div>

@endsection