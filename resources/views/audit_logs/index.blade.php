@extends('layouts.app')

@section('content')
<div class="mb-6">
<h1 class="text-2xl font-bold text-gray-800">Audit Log Aktivitas</h1>
<p class="text-gray-500">
Riwayat aktivitas user untuk memantau transaksi, produk, dan stok barang.
</p>
</div>

<form method="GET" action="{{ route('audit-logs.index') }}" class="bg-white p-4 rounded-2xl shadow mb-6 grid grid-cols-1 md:grid-cols-5 gap-4">
<input type="date" name="start_date" value="{{ request('start_date') }}" class="border rounded p-2">

<input type="date" name="end_date" value="{{ request('end_date') }}" class="border rounded p-2">

<select name="module" class="border rounded p-2">
<option value="">Semua Modul</option>
<option value="Produk" {{ request('module') == 'Produk' ? 'selected' : '' }}>Produk</option>
<option value="Transaksi" {{ request('module') == 'Transaksi' ? 'selected' : '' }}>Transaksi</option>
<option value="Mutasi Stok" {{ request('module') == 'Mutasi Stok' ? 'selected' : '' }}>Mutasi Stok</option>
<option value="Laporan" {{ request('module') == 'Laporan' ? 'selected' : '' }}>Laporan</option>
</select>

<select name="action" class="border rounded p-2">
<option value="">Semua Aksi</option>
<option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
<option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
<option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Delete</option>
<option value="print" {{ request('action') == 'print' ? 'selected' : '' }}>Print</option>
</select>

<button class="bg-blue-600 text-white px-4 py-2 rounded-lg"> Filter
</button>
</form>

<div class="bg-white rounded-2xl shadow overflow-hidden">
<table class="w-full">
<thead class="bg-gray-100 text-left">
 
<tr>
<th class="p-3">Waktu</th>
<th class="p-3">User</th>
<th class="p-3">Role</th>
<th class="p-3">Aksi</th>
<th class="p-3">Modul</th>
<th class="p-3">Keterangan</th>
<th class="p-3">IP</th>
</tr>
</thead>
<tbody>
@forelse($logs as $log)
<tr class="border-b">
<td class="p-3">
{{ $log->created_at->format('d-m-Y H:i') }}
</td>

<td class="p-3">
{{ $log->user->name ?? 'System' }}
</td>

<td class="p-3">
{{ $log->role }}
</td>

<td class="p-3">
@if($log->action == 'create')
<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm"> Create
</span>
@elseif($log->action == 'update')
<span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm"> Update
</span>
@elseif($log->action == 'delete')
<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm"> Delete
</span> @else
<span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
{{ $log->action }}
</span> @endif
</td>
 
<td class="p-3">
{{ $log->module }}
</td>

<td class="p-3">
{{ $log->description }}
</td>

<td class="p-3">
{{ $log->ip_address }}
</td>
</tr> @empty
<tr>
<td colspan="7" class="p-4 text-center text-gray-500"> Belum ada aktivitas tercatat.
</td>
</tr> @endforelse
</tbody>
</table>
</div>

<div class="mt-4">
{{ $logs->links() }}
</div> @endsection

