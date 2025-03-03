@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Lista de Produtos</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('produtos.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Adicionar Produto
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Nome</th>
                        <th class="py-3 px-6 text-center">Estoque</th>
                        <th class="py-3 px-6 text-center">Valor</th>
                        <th class="py-3 px-6 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @foreach ($produtos as $produto)
                        <tr class="border-b border-gray-300 hover:bg-gray-100">
                            <td class="py-3 px-6">{{ $produto->nome }}</td>
                            <td class="py-3 px-6 text-center">{{ $produto->estoque }}</td>
                            <td class="py-3 px-6 text-center">R$ {{ number_format($produto->valor, 2, ',', '.') }}</td>
                            <td class="py-3 px-6 flex justify-center space-x-2">
                                <a href="{{ route('produtos.edit', $produto->id) }}" 
                                   class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Editar</a>
                                <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" 
                                      onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
