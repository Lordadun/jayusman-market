<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jayusman Market</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-blue-900 flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-8">
        <div class="text-center mb-6">
            <div class="mx-auto w-16 h-16 rounded-2xl bg-blue-600 flex items-center justify-center text-white text-2xl font-bold mb-4">JM</div>
            <h1 class="text-2xl font-bold text-slate-800">Jayusman Market</h1>
            <p class="text-gray-500">Monitoring transaksi dan stok cabang</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block mb-1 font-medium text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="owner@jayusman.com" required>
            </div>
            <div>
                <label class="block mb-1 font-medium text-slate-700">Password</label>
                <input type="password" name="password" class="w-full border rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="password" required>
            </div>
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" name="remember" value="1" class="rounded"> Ingat saya
            </label>
            <button class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700">Login</button>
        </form>

        <div class="mt-6 text-sm text-gray-500 bg-gray-50 p-3 rounded-xl">
            Demo: owner@jayusman.com / password
        </div>
    </div>
</body>
</html>
