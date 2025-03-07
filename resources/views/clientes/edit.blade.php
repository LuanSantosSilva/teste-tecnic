@extends('layouts.app')

@section('titulo', 'Editar cliente')

@section('content')
    <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Editar Cliente</h1>

        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="nome" class="block text-gray-700 font-semibold">Nome:</label>
                <input type="text" name="nome" value="{{ $cliente->nome }}" required
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label for="cpf" class="block text-gray-700 font-semibold">CPF:</label>
                <input type="text" name="cpf" value="{{ $cliente->cpf }}" required
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-300">
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200">
                Atualizar Cliente
            </button>
        </form>
    </div>
@endsection
