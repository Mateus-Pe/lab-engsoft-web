<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proteus ERP — Engenharia + Web</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-14 items-center">
            <div class="flex items-center gap-2">
                <i data-feather="layers" class="text-indigo-600"></i>
                <span class="text-indigo-600 font-semibold text-lg tracking-tight">Proteus ERP</span>
                <span class="text-sm text-gray-500">Engenharia + Web</span>
            </div>
            <div class="hidden md:flex items-center gap-6 text-sm text-gray-600">
                <a href="/" class="flex items-center gap-1 hover:text-indigo-600 transition-colors">
                    <i data-feather="home"></i>
                    Dashboard
                </a>
                <a href="/Cliente/Listar" class="flex items-center gap-1 hover:text-indigo-600 transition-colors">
                    <i data-feather="user"></i>
                    Cliente
                </a>
                <a href="/Produto/Listar" class="flex items-center gap-1 hover:text-indigo-600 transition-colors">
                    <i data-feather="package"></i>
                    Produto
                </a>
                <a href="/Pedido/Listar" class="flex items-center gap-1 hover:text-indigo-600 transition-colors">
                    <i data-feather="file-text"></i>
                    Pedido
                </a>
            </div>
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-6 py-8 space-y-8">
    @hasSection('content')
        @yield('content')
    @else
        @include('dashboard')
    @endif
</main>

<footer class="mt-10 border-t border-gray-200 text-center text-xs text-gray-500 py-4">
    © {{ date('Y') }} Proteus ERP — Engenharia + Web
</footer>

<script>
    feather.replace();
</script>

</body>
</html>
