@extends('index')

@section('title', 'Lista de Clientes')

@section('content')
<div class="p-6 bg-white border rounded-lg shadow-sm">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                      d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Lista de Clientes
        </h2>

        <a href="/Cliente/Cadastrar">
        	<button class="bg-indigo-600 text-white px-4 py-1.5 rounded hover:bg-indigo-500 text-sm flex items-center gap-1">
	            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
	                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
	                      d="M12 4v16m8-8H4" />
	            </svg>
	            Novo Cliente
        	</button>
        </a>
    </div>

    <div class="overflow-hidden border rounded-lg">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Nome</th>
                    <th class="px-4 py-3 text-left">CPF</th>
                    <th class="px-4 py-3 text-left">Telefone</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Endereço</th>
                    <th class="px-4 py-3 text-left">Criado em</th>
                    <th class="px-4 py-3 text-center w-24">Ações</th>
                </tr>
            </thead>

            <tbody>
                @if(isset($Clientes) && count($Clientes) > 0)
                    @foreach($Clientes as $cliente)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $cliente['id'] }}</td>
                            <td class="px-4 py-3">{{ $cliente['nome'] }}</td>
                            <td class="px-4 py-3">{{ $cliente['cpf'] }}</td>
                            <td class="px-4 py-3">{{ $cliente['telefone'] }}</td>
                            <td class="px-4 py-3">{{ $cliente['email'] }}</td>
                            <td class="px-4 py-3">{{ $cliente['endereco'] }}</td>
                            <td class="px-4 py-3">{{ $cliente['criado_em'] }}</td>

                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="/Cliente/Editar/{{ $cliente['id'] }}" class="text-indigo-600 hover:text-indigo-800" title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </a>

                                    <a href="/Cliente/Deletar/{{ $cliente['id'] }}" 
                                       onclick="return confirm('Tem certeza que deseja excluir este cliente?')" 
                                       class="text-red-600 hover:text-red-800" title="Excluir">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-500">
                            Nenhum cliente encontrado.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
