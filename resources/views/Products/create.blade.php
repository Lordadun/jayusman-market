@extends('layouts.app')
@section('title', 'Tambah Produk')
@section('content')
<h1 class="text-2xl font-bold mb-6">Tambah Produk</h1><form action="{{ route('products.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm max-w-5xl">@csrf @include('products.form', ['product' => null])</form>
@endsection
