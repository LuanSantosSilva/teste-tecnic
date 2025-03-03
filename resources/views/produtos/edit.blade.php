@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Editar Produto</h1>

        <form action="{{ route('produtos.update', $produto->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="nome" class="block text-gray-700 font-semibold">Nome:</label>
                <input type="text" name="nome" value="{{ $produto->nome }}" required 
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label for="estoque" class="block text-gray-700 font-semibold">Estoque:</label>
                <input type="number" name="estoque" value="{{ $produto->estoque }}" min="0" required
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label for="valor" class="block text-gray-700 font-semibold">Valor:</label>
                <input type="number" name="valor" value="{{ $produto->valor }}" min="0" step="0.01" required
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-300">
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200">
                Atualizar Produto
            </button>
        </form>
    </div>
@endsection
