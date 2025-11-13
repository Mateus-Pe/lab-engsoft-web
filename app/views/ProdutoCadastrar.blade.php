@extends('index')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto bg-white border border-gray-200 rounded-md shadow-sm p-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Cadastro de Produto
        </h2>

        <form method="POST" action="/Produto/Salvar" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome do Produto <span class="text-red-500">*</span></label>
                    <input type="text" name="nome"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        placeholder="Ex: Notebook Dell Inspiron" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center justify-between">
                        <span>Descrição</span>
                        <button type="button" onclick="gerarDescricaoIA()" 
                            class="bg-purple-600 hover:bg-purple-700 text-white text-xs px-3 py-1 rounded flex items-center gap-1"
                            id="btnIA">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Gerar com IA
                        </button>
                    </label>
                    <textarea name="descricao" id="descricao" rows="3"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        placeholder="Descrição detalhada do produto..."></textarea>
                    <p class="text-xs text-gray-500 mt-1" id="statusIA"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preço (R$) <span class="text-red-500">*</span></label>
                    <input type="number" name="preco" step="0.01" min="0"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        placeholder="0.00" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estoque</label>
                    <input type="number" name="estoque" min="0"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        placeholder="0" value="0">
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium px-6 py-2.5 text-sm rounded-sm transition">
                    Salvar Produto
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function gerarDescricaoIA() {
    const btnIA = document.getElementById('btnIA');
    const statusIA = document.getElementById('statusIA');
    const descricao = document.getElementById('descricao');
    
    const nome = document.querySelector('input[name="nome"]').value;
    const preco = document.querySelector('input[name="preco"]').value;
    const estoque = document.querySelector('input[name="estoque"]').value;
    
    if (!nome) {
        alert('Por favor, preencha pelo menos o nome do produto!');
        return;
    }
    
    btnIA.disabled = true;
    btnIA.innerHTML = '<svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Gerando...';
    statusIA.textContent = 'Consultando IA...';
    statusIA.className = 'text-xs text-blue-600 mt-1';
    
    fetch('/api/gemini/produto', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            nome: nome,
            descricao: descricao.value,
            preco: preco,
            estoque: estoque
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.observacao) {
            descricao.value = data.observacao;
            statusIA.textContent = '✓ Descrição gerada com sucesso!';
            statusIA.className = 'text-xs text-green-600 mt-1';
        } else {
            statusIA.textContent = 'Erro ao gerar descrição';
            statusIA.className = 'text-xs text-red-600 mt-1';
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        statusIA.textContent = 'Erro ao conectar com a IA';
        statusIA.className = 'text-xs text-red-600 mt-1';
    })
    .finally(() => {
        btnIA.disabled = false;
        btnIA.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg> Gerar com IA';
        
        setTimeout(() => {
            statusIA.textContent = '';
        }, 3000);
    });
}
</script>
@endsection

