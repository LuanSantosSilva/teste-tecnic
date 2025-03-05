@extends('layouts.app')

@section('titulo', 'Cadastro de produtos')

@section('content')
    <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Cadastro de Produto</h1>

        <form method="POST" action="{{ route('produtos.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="nome" class="block text-gray-700 font-semibold">Nome:</label>
                <input type="text" name="nome" required 
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label for="valor" class="block text-gray-700 font-semibold">Valor:</label>
                <input type="text" id="valor" name="valor" required placeholder="R$ 0,00"
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label for="estoque" class="block text-gray-700 font-semibold">Estoque:</label>
                <input type="number" name="estoque" min="0" value="0" required
                    class="border border-gray-300 rounded-lg p-2 w-full focus:ring focus:ring-blue-300">
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200">
                Cadastrar Produto
            </button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#valor').on('input', function () {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length < 3) {
                    value = value.padStart(3, '0');
                }
                let integerPart = value.slice(0, -2);
                let decimalPart = value.slice(-2);
                let formattedValue = integerPart + ',' + decimalPart;
                formattedValue = formattedValue.replace(/^0+(?=\d)/, '');
                $(this).val(formattedValue);
            });

            $('form').on('submit', function () {
                let valorInput = $('#valor');
                let valorSemFormatacao = valorInput.val().replace(/\./g, '').replace(',', '.');
                valorInput.val(valorSemFormatacao);
            });
        });
    </script>
@endsection
