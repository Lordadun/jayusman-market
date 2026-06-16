@extends('layouts.app')
@section('title', 'Edit Produk')
@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Produk</h1><form action="{{ route('products.update',$product) }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm max-w-5xl">@csrf @method('PUT') @include('products.form', ['product' => $product])</form>
@endsection
