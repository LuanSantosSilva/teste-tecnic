@extends('layouts.app')

@section('titulo', 'Login')

@section('content')
    <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Login</h1>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-gray-700 font-semibold">Email:</label>
                <input type="email" name="email" required
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label for="password" class="block text-gray-700 font-semibold">Senha:</label>
                <input type="password" name="password" required
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-300">
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200">
                Entrar
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Criar uma conta</a>
        </div>
    </div>
@endsection
