@extends('layouts.app')
@section('title', 'Cabang')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div><h1 class="text-2xl font-bold">Data Cabang</h1><p class="text-gray-500">Kelola 5 cabang mini market.</p></div>
    <a href="{{ route('branches.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-xl">Tambah Cabang</a>
</div>
<div class="bg-white rounded-2xl shadow-sm overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-100"><tr><th class="p-3 text-left">Nama</th><th class="p-3 text-left">Kota</th><th class="p-3 text-left">Alamat</th><th class="p-3">Produk</th><th class="p-3">User</th><th class="p-3">Aksi</th></tr></thead>
        <tbody>
            @foreach($branches as $branch)
            <tr class="border-b">
                <td class="p-3 font-semibold">{{ $branch->name }}</td><td class="p-3">{{ $branch->city }}</td><td class="p-3">{{ $branch->address }}</td><td class="p-3 text-center">{{ $branch->products_count }}</td><td class="p-3 text-center">{{ $branch->users_count }}</td>
                <td class="p-3 flex gap-2 justify-center"><a href="{{ route('branches.edit',$branch) }}" class="bg-yellow-400 px-3 py-1 rounded-lg">Edit</a><form action="{{ route('branches.destroy',$branch) }}" method="POST" onsubmit="return confirm('Hapus cabang?')">@csrf @method('DELETE')<button class="bg-red-500 text-white px-3 py-1 rounded-lg">Hapus</button></form></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $branches->links() }}</div>
@endsection
