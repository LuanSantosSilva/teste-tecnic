<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venda #{{ $venda->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Detalhes da Venda #{{ $venda->id }}</h2>
    <p><strong>Cliente:</strong> {{ $venda->cliente->nome }}</p>
    <p><strong>CPF:</strong> {{ $venda->cliente->cpf }}</p>
    <p><strong>Valor Total:</strong> R$ {{ number_format($venda->valor, 2, ',', '.') }}</p>
    <p><strong>Parcelas:</strong> {{ $venda->qtnd_parcelas }}</p>

    <h3>Produtos</h3>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($venda->produtos as $produto)
                <tr>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->pivot->quantidade }}</td>
                    <td>R$ {{ number_format($produto->valor, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format($produto->pivot->quantidade * $produto->valor, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
