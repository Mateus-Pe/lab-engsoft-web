<?php

namespace App\Controllers;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Pedido;

class ProdutosController extends Controller
{
    public function index()
    {
        response()->render('produto');
    }

    public function Listar()
    {
        $ProdutoModel = new Produto();
        $Produtos = $ProdutoModel->Listar();

        response()->render('ProdutoListar', ['Produtos' => $Produtos]);
    }
}
