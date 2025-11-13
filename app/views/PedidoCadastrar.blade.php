@extends('index')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto bg-white border border-gray-200 rounded-md shadow-sm p-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" 
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Cadastro de Pedido
        </h2>

        <form method="POST" action="/Pedido/Salvar" id="formPedido" class="space-y-6">
            <!-- Dados do Pedido -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cliente <span class="text-red-500">*</span></label>
                    <select name="cliente_id" 
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        required>
                        <option value="">Selecione um cliente</option>
                        @if(isset($Clientes) && count($Clientes) > 0)
                            @foreach($Clientes as $cliente)
                                <option value="{{ $cliente['id'] }}">{{ $cliente['nome'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm">
                        <option value="Pendente">Pendente</option>
                        <option value="Em Processamento">Em Processamento</option>
                        <option value="Concluído">Concluído</option>
                        <option value="Cancelado">Cancelado</option>
                    </select>
                </div>
            </div>

            <!-- Produtos do Pedido -->
            <div class="border-t pt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Produtos do Pedido</h3>
                    <button type="button" onclick="adicionarProduto()" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-sm text-sm flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Adicionar Produto
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Produto</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Preço Unit.</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Quantidade</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Subtotal</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase w-20">Ação</th>
                            </tr>
                        </thead>
                        <tbody id="listaProdutos">
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500 text-sm">
                                    Nenhum produto adicionado. Clique em "Adicionar Produto" para começar.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total -->
            <div class="border-t pt-4">
                <div class="flex justify-end">
                    <div class="bg-gray-50 border rounded-lg p-4 min-w-[250px]">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-700">Total do Pedido:</span>
                            <span class="text-2xl font-bold text-indigo-600" id="totalPedido">R$ 0,00</span>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="total" id="totalInput" value="0">

            <div class="flex justify-between mt-8">
                <a href="/Pedido/Listar" class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-6 py-2.5 text-sm rounded-sm transition">
                    Cancelar
                </a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium px-6 py-2.5 text-sm rounded-sm transition">
                    Salvar Pedido
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Dados dos produtos disponíveis
const produtos = [
    @if(isset($Produtos) && count($Produtos) > 0)
        @foreach($Produtos as $produto)
            {
                id: {{ $produto['id'] }},
                nome: "{{ $produto['nome'] }}",
                preco: {{ $produto['preco'] }}
            },
        @endforeach
    @endif
];

let contadorProdutos = 0;

function adicionarProduto() {
    const tbody = document.getElementById('listaProdutos');
    
    // Remove a mensagem de "nenhum produto"
    if (tbody.children.length === 1 && tbody.children[0].querySelector('td[colspan]')) {
        tbody.innerHTML = '';
    }

    const row = document.createElement('tr');
    row.className = 'border-t hover:bg-gray-50';
    row.id = `produto-${contadorProdutos}`;
    
    row.innerHTML = `
        <td class="px-4 py-3">
            <select name="produtos[${contadorProdutos}][produto_id]" 
                onchange="atualizarPreco(${contadorProdutos})" 
                class="w-full border border-gray-300 rounded px-2 py-1 text-sm" required>
                <option value="">Selecione um produto</option>
                ${produtos.map(p => `<option value="${p.id}" data-preco="${p.preco}">${p.nome}</option>`).join('')}
            </select>
        </td>
        <td class="px-4 py-3">
            <input type="text" 
                id="preco-${contadorProdutos}" 
                readonly 
                class="w-24 border border-gray-300 rounded px-2 py-1 text-sm bg-gray-50" 
                value="R$ 0,00">
            <input type="hidden" name="produtos[${contadorProdutos}][preco_unitario]" id="preco-input-${contadorProdutos}" value="0">
        </td>
        <td class="px-4 py-3">
            <input type="number" 
                name="produtos[${contadorProdutos}][quantidade]" 
                id="quantidade-${contadorProdutos}"
                onchange="calcularSubtotal(${contadorProdutos})" 
                min="1" 
                value="1" 
                class="w-20 border border-gray-300 rounded px-2 py-1 text-sm" required>
        </td>
        <td class="px-4 py-3">
            <span class="font-semibold text-gray-700" id="subtotal-${contadorProdutos}">R$ 0,00</span>
        </td>
        <td class="px-4 py-3 text-center">
            <button type="button" 
                onclick="removerProduto(${contadorProdutos})" 
                class="text-red-600 hover:text-red-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </td>
    `;
    
    tbody.appendChild(row);
    contadorProdutos++;
}

function atualizarPreco(index) {
    const select = document.querySelector(`select[name="produtos[${index}][produto_id]"]`);
    const precoDisplay = document.getElementById(`preco-${index}`);
    const precoInput = document.getElementById(`preco-input-${index}`);
    
    if (select.value) {
        const preco = parseFloat(select.options[select.selectedIndex].dataset.preco);
        precoDisplay.value = `R$ ${preco.toFixed(2).replace('.', ',')}`;
        precoInput.value = preco;
        calcularSubtotal(index);
    } else {
        precoDisplay.value = 'R$ 0,00';
        precoInput.value = 0;
        calcularSubtotal(index);
    }
}

function calcularSubtotal(index) {
    const preco = parseFloat(document.getElementById(`preco-input-${index}`).value) || 0;
    const quantidade = parseInt(document.getElementById(`quantidade-${index}`).value) || 0;
    const subtotal = preco * quantidade;
    
    document.getElementById(`subtotal-${index}`).textContent = `R$ ${subtotal.toFixed(2).replace('.', ',')}`;
    calcularTotal();
}

function calcularTotal() {
    let total = 0;
    const tbody = document.getElementById('listaProdutos');
    
    for (let i = 0; i < contadorProdutos; i++) {
        const row = document.getElementById(`produto-${i}`);
        if (row) {
            const preco = parseFloat(document.getElementById(`preco-input-${i}`).value) || 0;
            const quantidade = parseInt(document.getElementById(`quantidade-${i}`).value) || 0;
            total += preco * quantidade;
        }
    }
    
    document.getElementById('totalPedido').textContent = `R$ ${total.toFixed(2).replace('.', ',')}`;
    document.getElementById('totalInput').value = total.toFixed(2);
}

function removerProduto(index) {
    const row = document.getElementById(`produto-${index}`);
    if (row) {
        row.remove();
        calcularTotal();
        
        // Se não houver mais produtos, mostra a mensagem
        const tbody = document.getElementById('listaProdutos');
        if (tbody.children.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-500 text-sm">
                        Nenhum produto adicionado. Clique em "Adicionar Produto" para começar.
                    </td>
                </tr>
            `;
        }
    }
}
</script>
@endsection

