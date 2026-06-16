<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jayusman Market')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-slate-800">
<div class="flex min-h-screen">
    <aside class="w-72 bg-slate-950 text-white p-5 hidden lg:block">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center font-bold">JM</div>
            <div>
                <h1 class="font-bold text-lg">Jayusman Mart</h1>
                <p class="text-xs text-slate-400">Monitoring System</p>
            </div>
        </div>

        <nav class="space-y-1 text-sm">
            <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl hover:bg-slate-800">Dashboard</a>
            @if(auth()->user()->role === 'owner')
                <a href="{{ route('branches.index') }}" class="block px-4 py-3 rounded-xl hover:bg-slate-800">Cabang</a>
                <a href="{{ route('users.index') }}" class="block px-4 py-3 rounded-xl hover:bg-slate-800">Pengguna</a>
            @endif
            @if(in_array(auth()->user()->role, ['owner','manager','supervisor','warehouse']))
                <a href="{{ route('categories.index') }}" class="block px-4 py-3 rounded-xl hover:bg-slate-800">Kategori</a>
                <a href="{{ route('products.index') }}" class="block px-4 py-3 rounded-xl hover:bg-slate-800">Produk</a>
                <a href="{{ route('stock-mutations.index') }}" class="block px-4 py-3 rounded-xl hover:bg-slate-800">Mutasi Stok</a>
            @endif
            @if(in_array(auth()->user()->role, ['owner','manager','supervisor','cashier']))
                <a href="{{ route('transactions.index') }}" class="block px-4 py-3 rounded-xl hover:bg-slate-800">Transaksi</a>
            @endif
            @if(in_array(auth()->user()->role, ['owner','manager']))
                <a href="{{ route('reports.transactions') }}" class="block px-4 py-3 rounded-xl hover:bg-slate-800">Laporan Transaksi</a>
                <a href="{{ route('reports.stocks') }}" class="block px-4 py-3 rounded-xl hover:bg-slate-800">Laporan Stok</a>
                @if(in_array(auth()->user()->role, ['owner','manager']))
                <a href="{{ route('audit-logs.index') }}" class="block px-4 py-3 rounded hover:bg-slate-700"> Audit Log
                </a>
                @endif
        </nav>
    </aside>

    <main class="flex-1 min-w-0">
        <header class="bg-white shadow-sm px-4 md:px-6 py-4 flex justify-between items-center sticky top-0 z-10">
            <div>
                <p class="font-bold">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500 uppercase tracking-wide">{{ auth()->user()->role }} @if(auth()->user()->branch) - {{ auth()->user()->branch->name }} @endif</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded-xl hover:bg-red-600">Logout</button>
            </form>
        </header>

        <section class="p-4 md:p-6">
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </section>
    </main>
</div>
</body>
</html>
