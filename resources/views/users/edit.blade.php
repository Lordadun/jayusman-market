@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Pengguna</h1><form action="{{ route('users.update',$user) }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm max-w-4xl">@csrf @method('PUT') @include('users.form', ['user' => $user])</form>
@endsection
