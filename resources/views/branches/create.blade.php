@extends('layouts.app')
@section('title', 'Tambah Cabang')
@section('content')
<h1 class="text-2xl font-bold mb-6">Tambah Cabang</h1>
<form action="{{ route('branches.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm space-y-4 max-w-3xl">@csrf
    @include('branches.form', ['branch' => null])
</form>
@endsection
