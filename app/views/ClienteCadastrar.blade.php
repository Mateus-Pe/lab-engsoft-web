@extends('index')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto bg-white border border-gray-200 rounded-md shadow-sm p-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Cadastro de Cliente
        </h2>

        <form method="POST" action="/clientes/salvar" class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome <span class="text-red-500">*</span></label>
                    <input type="text" name="nome"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        placeholder="Ex: João da Silva" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CPF <span class="text-red-500">*</span></label>
                    <input type="text" name="cpf"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        placeholder="000.000.000-00" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telefone</label>
                    <input type="text" name="telefone"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        placeholder="(15) 99999-9999">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        placeholder="email@exemplo.com">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Endereço</label>
                    <input type="text" name="endereco"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        placeholder="Rua, número, bairro...">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                    <textarea name="observacoes" rows="4"
                        class="w-full border border-gray-300 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-gray-800 rounded-sm px-3 py-2.5 text-sm"
                        placeholder="Informações adicionais do cliente..."></textarea>
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white font-medium px-6 py-2.5 text-sm rounded-sm transition">
                    Salvar Cliente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
