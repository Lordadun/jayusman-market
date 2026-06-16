@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Kategori</h1><form action="{{ route('categories.update',$category) }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm space-y-4 max-w-3xl">@csrf @method('PUT') @include('categories.form', ['category' => $category])</form>
@endsection
