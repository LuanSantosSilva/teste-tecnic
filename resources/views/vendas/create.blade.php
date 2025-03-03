@extends('layouts.app')

@section('content')
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Nova Venda</h1>

        <form method="POST" action="{{ route('vendas.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="cliente" class="block font-medium text-gray-700">Cliente:</label>
                <select name="cliente_id" required class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    <option value="">Selecione um cliente</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                    @endforeach
                </select>
            </div>

            <h2 class="text-lg font-semibold text-gray-700">Produtos</h2>
            <div id="produtos-container" class="space-y-2">
                <div class="produto-item flex items-center gap-2">
                    <select name="produtos[]" class="produto-select w-full p-2 border rounded-md" required>
                        <option value="">Selecione um produto</option>
                        @foreach ($produtos as $produto)
                            @if ($produto->estoque > 0)
                                <option value="{{ $produto->id }}" data-preco="{{ $produto->valor }}" data-estoque="{{ $produto->estoque }}">
                                    {{ $produto->nome }} - R$ {{ number_format($produto->valor, 2, ',', '.') }} ({{ $produto->estoque }} disponíveis)
                                </option>
                            @endif
                        @endforeach
                    </select>
                    <input type="number" name="quantidades[]" class="quantidade w-20 p-2 border rounded-md text-center" min="1" required>
                    <button type="button" class="remover-produto bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-700 hidden">Remover</button>
                </div>
            </div>

            <button type="button" id="add-produto" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Adicionar Produto
            </button>

            <h2 class="text-lg font-semibold text-gray-700">Parcelas</h2>
            <div id="parcelas-container" class="space-y-2"></div>

            <button type="button" id="add-parcela" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-700">
                Adicionar Parcela
            </button>

            <div class="mt-4">
                <h3 class="text-xl font-bold text-gray-700">Total da Venda: R$ <span id="total-venda">0.00</span></h3>
                <h3 class="text-xl font-bold text-gray-700">Diferença: R$ <span id="diferenca">0.00</span></h3>
                <h3 class="text-xl font-bold text-gray-700">Total das Parcelas: R$ <span id="total-parcelas">0.00</span></h3>
            </div>

            <button type="submit" id="finalizar-venda" disabled class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                Finalizar Venda
            </button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/vendas.js') }}?v={{ time() }}"></script>
@endsection
