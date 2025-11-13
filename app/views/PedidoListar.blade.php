@extends('index')

@section('title', 'Lista de Pedidos')

@section('content')
<div class="p-6 bg-white border rounded-lg shadow-sm">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Lista de Pedidos
        </h2>

        <a href="/Pedido/Cadastrar">
            <button class="bg-indigo-600 text-white px-4 py-1.5 rounded hover:bg-indigo-500 text-sm flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4v16m8-8H4" />
                </svg>
                Novo Pedido
            </button>
        </a>
    </div>

    <div class="overflow-hidden border rounded-lg">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Cliente</th>
                    <th class="px-4 py-3 text-left">Data do Pedido</th>
                    <th class="px-4 py-3 text-left">Total (R$)</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-center w-24">Ações</th>
                </tr>
            </thead>

            <tbody>
                @if(isset($Pedidos) && count($Pedidos) > 0)
                    @foreach($Pedidos as $pedido)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $pedido['id'] }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $pedido['cliente_nome'] ?? 'N/A' }}</td>
                            <td class="px-4 py-3">{{ date('d/m/Y H:i', strtotime($pedido['data_pedido'])) }}</td>
                            <td class="px-4 py-3">R$ {{ number_format($pedido['total'], 2, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded 
                                    @if($pedido['status'] == 'Pendente') bg-yellow-100 text-yellow-800
                                    @elseif($pedido['status'] == 'Concluído') bg-green-100 text-green-800
                                    @elseif($pedido['status'] == 'Cancelado') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $pedido['status'] }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="/Pedido/Editar/{{ $pedido['id'] }}" 
                                       class="bg-indigo-600 text-white px-3 py-1 rounded text-xs hover:bg-indigo-700">
                                        Editar
                                    </a>

                                    <a href="/Pedido/Deletar/{{ $pedido['id'] }}" 
                                       onclick="return confirm('Tem certeza que deseja excluir este pedido?')" 
                                       class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">
                                        Excluir
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">
                            Nenhum pedido encontrado.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection

