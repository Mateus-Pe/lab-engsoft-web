<?php

// Página inicial com dashboard
app()->get('/', function() {
    response()->render('index');
});

// Rotas de Clientes
app()->get('/Cliente/Cadastrar', 'ClientesController@Cadastrar');
app()->post('/Cliente/Salvar', 'ClientesController@Salvar');
app()->get('/Cliente/Listar', 'ClientesController@Listar');
app()->get('/Cliente/Editar/{id}', 'ClientesController@Editar');
app()->post('/Cliente/Atualizar/{id}', 'ClientesController@Atualizar');
app()->get('/Cliente/Deletar/{id}', 'ClientesController@Deletar');

// Rotas de Produtos
app()->get('/Produto/Cadastrar', 'ProdutosController@Cadastrar');
app()->post('/Produto/Salvar', 'ProdutosController@Salvar');
app()->get('/Produto/Listar', 'ProdutosController@Listar');
app()->get('/Produto/Editar/{id}', 'ProdutosController@Editar');
app()->post('/Produto/Atualizar/{id}', 'ProdutosController@Atualizar');
app()->get('/Produto/Deletar/{id}', 'ProdutosController@Deletar');

// Rotas de Pedidos
app()->get('/Pedido/Cadastrar', 'PedidosController@Cadastrar');
app()->post('/Pedido/Salvar', 'PedidosController@Salvar');
app()->get('/Pedido/Listar', 'PedidosController@Listar');
app()->get('/Pedido/Editar/{id}', 'PedidosController@Editar');
app()->post('/Pedido/Atualizar/{id}', 'PedidosController@Atualizar');
app()->get('/Pedido/Deletar/{id}', 'PedidosController@Deletar');

// Rotas de IA (Gemini)
app()->post('/api/gemini/cliente', 'GeminiController@gerarObservacaoCliente');
app()->post('/api/gemini/produto', 'GeminiController@gerarObservacaoProduto');
