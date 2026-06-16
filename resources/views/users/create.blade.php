@extends('layouts.app')
@section('title', 'Tambah User')
@section('content')
<h1 class="text-2xl font-bold mb-6">Tambah Pengguna</h1><form action="{{ route('users.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm max-w-4xl">@csrf @include('users.form', ['user' => null])</form>
@endsection
