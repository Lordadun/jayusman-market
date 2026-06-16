@extends('layouts.app')
@section('title', 'Tambah Kategori')
@section('content')
<h1 class="text-2xl font-bold mb-6">Tambah Kategori</h1><form action="{{ route('categories.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm space-y-4 max-w-3xl">@csrf @include('categories.form', ['category' => null])</form>
@endsection
