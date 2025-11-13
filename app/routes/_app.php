<?php

app()->view('/', 'index');

//Clientes
app()->get('/Cliente/Cadastrar', 'ClientesController@Cadastrar');
app()->post('/Cliente/Salvar', 'ClientesController@Salvar');
app()->get('/Cliente/Listar', 'ClientesController@Listar');
app()->post('/Cliente/Deletar/{id}', 'ClientesController@Deletar');


app()->get('/Produto/Cadastrar', 'ProdutosController@Cadastrar');
app()->post('/Produto/Salvar', 'ProdutosController@Salvar');
app()->get('/Produto/Listar', 'ProdutosController@Listar');
app()->get('/Produto/Deletar/{id}', 'ProdutosController@Deletar');

app()->get('/Pedido/Cadastrar', 'PedidosController@Cadastrar');
app()->post('/Pedido/Salvar', 'PedidosController@Salvar');
app()->get('/Pedido/Listar', 'PedidosController@Listar');
app()->get('/Pedido/Deletar/{id}', 'PedidosController@Deletar');