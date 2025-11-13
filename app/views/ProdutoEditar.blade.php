@extends('index')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto bg-white border border-gray-200 rounded-md shadow-sm p-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Editar Produto
        </h2>

        <form method="POST" action="/Produto/Atualizar/{{ $Produto['id'] }}" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome do Produto <span class="text-red-500">*</span></label>
                    <input type="text" name="nome" value="{{ $Produto['nome'] }}"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        placeholder="Ex: Notebook Dell Inspiron" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                    <textarea name="descricao" rows="3"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        placeholder="Descrição detalhada do produto...">{{ $Produto['descricao'] }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Preço (R$) <span class="text-red-500">*</span></label>
                    <input type="number" name="preco" step="0.01" min="0" value="{{ $Produto['preco'] }}"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        placeholder="0.00" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estoque</label>
                    <input type="number" name="estoque" min="0" value="{{ $Produto['estoque'] }}"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        placeholder="0">
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <a href="/Produto/Listar" class="bg-gray-500 hover:bg-gray-600 text-white font-medium px-6 py-2.5 text-sm rounded-sm transition">
                    Cancelar
                </a>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium px-6 py-2.5 text-sm rounded-sm transition">
                    Atualizar Produto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

