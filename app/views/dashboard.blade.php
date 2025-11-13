@php
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Pedido;

$clienteModel = new Cliente();
$produtoModel = new Produto();
$pedidoModel = new Pedido();

$totalClientes = $clienteModel->Contar();
$totalProdutos = $produtoModel->Contar();
$totalPedidos = $pedidoModel->Contar();
$faturamentoTotal = $pedidoModel->SomarTotal();
@endphp

<section>
    <h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center gap-2">
        <i data-feather="activity" class="text-indigo-600"></i>
        Dashboard
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="border border-gray-200 bg-white p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-500">Clientes</span>
                <i data-feather="users" class="text-indigo-600"></i>
            </div>
            <p class="text-2xl font-semibold text-gray-700">{{ $totalClientes }}</p>
            <p class="text-xs text-gray-400">Cadastrados no sistema</p>
        </div>

        <div class="border border-gray-200 bg-white p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-500">Produtos</span>
                <i data-feather="box" class="text-indigo-600"></i>
            </div>
            <p class="text-2xl font-semibold text-gray-700">{{ $totalProdutos }}</p>
            <p class="text-xs text-gray-400">Ativos no estoque</p>
        </div>

        <div class="border border-gray-200 bg-white p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-500">Pedidos</span>
                <i data-feather="shopping-cart" class="text-indigo-600"></i>
            </div>
            <p class="text-2xl font-semibold text-gray-700">{{ $totalPedidos }}</p>
            <p class="text-xs text-gray-400">Registrados no sistema</p>
        </div>

        <div class="border border-gray-200 bg-white p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm text-gray-500">Faturamento</span>
                <i data-feather="dollar-sign" class="text-indigo-600"></i>
            </div>
            <p class="text-2xl font-semibold text-gray-700">R$ {{ number_format($faturamentoTotal, 2, ',', '.') }}</p>
            <p class="text-xs text-gray-400">Total de pedidos</p>
        </div>
    </div>
</section>

