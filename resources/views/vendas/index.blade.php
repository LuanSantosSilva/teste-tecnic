@extends('layouts.app')

@section('titulo', 'Vendas')

@section('content')
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

    <div class="max-w-full mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Lista de Vendas</h1>

        <form method="GET" action="{{ route('vendas.index') }}" class="mb-6 flex space-x-4 items-end">
            <div>
                <label for="cliente_cpf" class="block text-gray-700 font-semibold">CPF do Cliente:</label>
                <input type="text" name="cliente_cpf" id="cliente_cpf" value="{{ request('cliente_cpf') }}"
                       placeholder="Digite o CPF"
                       class="border border-gray-300 rounded-lg p-2 w-full">
            </div>
        
        
            <div>
                <label for="cliente_nome" class="block text-gray-700 font-semibold">Nome do Cliente:</label>
                <input type="text" name="cliente_nome" id="cliente_nome" value="{{ request('cliente_nome') }}"
                       placeholder="Digite o nome do cliente"
                       class="border border-gray-300 rounded-lg p-2 w-full">
            </div>
        
            <div>
                <label for="cliente_id" class="block text-gray-700 font-semibold">Cliente:</label>
                <select name="cliente_id" id="cliente_id" class="border border-gray-300 rounded-lg p-2 w-full">
                    <option value="">Todos</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ request('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Filtrar
            </button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Vendedor</th>
                        <th class="py-3 px-6 text-left">Cliente</th>
                        <th class="py-3 px-6 text-left">CPF</th>
                        <th class="py-3 px-6 text-center">Valor</th>
                        <th class="py-3 px-6 text-center">Parcelas</th>
                        <th class="py-3 px-6 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @foreach ($vendas as $venda)
                        <tr class="border-b border-gray-300 hover:bg-gray-100">
                            <td class="py-3 px-6">{{ $venda->user->name }}</td>
                            <td class="py-3 px-6">{{ $venda->cliente->nome }}</td>
                            <td class="py-3 px-6">{{ $venda->cliente->cpf }}</td>
                            <td class="py-3 px-6 text-center font-semibold text-green-600">
                                R$ {{ number_format($venda->valor, 2, ',', '.') }}
                            </td>
                            <td class="py-3 px-6 text-center">{{ $venda->qtnd_parcelas }}</td>
                            <td class="py-3 px-6 flex justify-center space-x-2">
                                <a href="{{ route('vendas.edit', $venda->id) }}" 
                                   class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">Editar</a>
                                   <a href="{{ route('vendas.pdf', $venda->id) }}" 
                                    class="bg-purple-500 text-white px-3 py-1 rounded hover:bg-purple-600" target="_blank">Gerar PDF</a>
                                <form action="{{ route('vendas.destroy', $venda->id) }}" method="POST" 
                                      onsubmit="return confirm('Tem certeza que deseja excluir esta venda?')">
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
