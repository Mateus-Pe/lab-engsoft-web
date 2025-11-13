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

    public function Cadastrar()
    {
        response()->render('ProdutoCadastrar');
    }

    public function Salvar()
    {
        $dados = request()->body();
        $ProdutoModel = new Produto();
        
        if ($ProdutoModel->Criar($dados)) {
            response()->redirect('/Produto/Listar');
        } else {
            response()->json(['error' => 'Erro ao salvar produto'], 500);
        }
    }

    public function Listar()
    {
        $ProdutoModel = new Produto();
        $Produtos = $ProdutoModel->Listar();

        response()->render('ProdutoListar', ['Produtos' => $Produtos]);
    }

    public function Editar($id)
    {
        $ProdutoModel = new Produto();
        $Produto = $ProdutoModel->BuscarPorId($id);

        if (!$Produto) {
            response()->redirect('/Produto/Listar');
            return;
        }

        response()->render('ProdutoEditar', ['Produto' => $Produto]);
    }

    public function Atualizar($id)
    {
        $dados = request()->body();
        $ProdutoModel = new Produto();
        
        if ($ProdutoModel->Atualizar($id, $dados)) {
            response()->redirect('/Produto/Listar');
        } else {
            response()->json(['error' => 'Erro ao atualizar produto'], 500);
        }
    }

    public function Deletar($id)
    {
        $ProdutoModel = new Produto();
        
        if ($ProdutoModel->Deletar($id)) {
            response()->redirect('/Produto/Listar');
        } else {
            response()->json(['error' => 'Erro ao deletar produto'], 500);
        }
    }
}
