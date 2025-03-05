@extends('layouts.app')

@section('titulo', 'Home')

@section('content')
    <h1 class="text-2xl text-center font-bold text-gray-800 mb-4">Bem Vindo, {{ $user->name }}!</h1>
@endsection
