@extends('layouts.app')

@section('titulo', 'Clientes')

@section('content')
    <div class="max-w-full mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Lista de Clientes</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-end mb-4">
            <a href="{{ route('clientes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Adicionar Cliente
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Nome</th>
                        <th class="py-3 px-6 text-center">CPF</th>
                        <th class="py-3 px-6 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @foreach ($clientes as $cliente)
                        <tr class="border-b border-gray-300 hover:bg-gray-100">
                            <td class="py-3 px-6">{{ $cliente->nome }}</td>
                            <td class="py-3 px-6 text-center">{{ $cliente->cpf }}</td>
                            <td class="py-3 px-6 flex justify-center space-x-2">
                                <a href="{{ route('clientes.edit', $cliente->id) }}" 
                                   class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Editar</a>
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" 
                                      onsubmit="return confirm('Tem certeza que deseja excluir este cliente?')">
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
