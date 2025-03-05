<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>LuanSant - @yield('titulo')</title>
        <meta charset="utf-8">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-gray-100 text-gray-900">
        <nav class="bg-blue-600 text-white py-4 shadow-md">
            <div class="container mx-auto flex justify-between items-center px-6">
                <a href="{{ route('home') }}" class="text-2xl font-bold">&#60;LuanSant/&#62;</a>

                <div class="space-x-6">
                    <a href="{{ route('vendas.create') }}" class="hover:text-gray-200">Realizar venda</a>
                    <a href="{{ route('produtos.index') }}" class="hover:text-gray-200">Cadastro de Produtos</a>
                    <a href="{{ route('clientes.index') }}" class="hover:text-gray-200">Cadastro de Clientes</a>
                    <a href="{{ route('vendas.index') }}" class="hover:text-gray-200">Vendas</a>
                    @auth
                        <a class="hover:text-gray-200" href="{{ route('logout') }}"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endauth
                </div>
            </div>
        </nav>
        
        <div class="container mx-auto min-h-screen flex flex-col items-center justify-center p-6">
            <main class="w-full max-w-full bg-white shadow-lg rounded-lg p-6 mt-6">
                @yield('content')
            </main>
        </div>

        <footer class="w-full text-center text-gray-600 py-4 mt-6 border-t">
            Copyright &copy; {{ date('Y') }} - by Luan Santos
        </footer>
    </body>
</html>
