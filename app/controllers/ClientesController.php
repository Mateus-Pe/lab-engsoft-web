<?php

namespace App\Controllers;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Pedido;

class ClientesController extends Controller
{
    public function index()
    {

        response()->render('cliente');
    }

    public function Cadastrar()
    {
        response()->render('ClienteCadastrar');
    }

    public function Salvar()
    {
        $dados = request()->body();
        $ClienteModel = new Cliente();
        
        if ($ClienteModel->Criar($dados)) {
            response()->redirect('/Cliente/Listar');
        } else {
            response()->json(['error' => 'Erro ao salvar cliente'], 500);
        }
    }

    public function Listar()
    {
       $ClienteModel = new Cliente();
       $Clientes = $ClienteModel->Listar();

       response()->render('ClienteListar', ['Clientes' => $Clientes]);
    }

    public function Editar($id)
    {
        $ClienteModel = new Cliente();
        $Cliente = $ClienteModel->BuscarPorId($id);

        if (!$Cliente) {
            response()->redirect('/Cliente/Listar');
            return;
        }

        response()->render('ClienteEditar', ['Cliente' => $Cliente]);
    }

    public function Atualizar($id)
    {
        $dados = request()->body();
        $ClienteModel = new Cliente();
        
        if ($ClienteModel->Atualizar($id, $dados)) {
            response()->redirect('/Cliente/Listar');
        } else {
            response()->json(['error' => 'Erro ao atualizar cliente'], 500);
        }
    }

    public function Deletar($id)
    {
        $ClienteModel = new Cliente();
        
        if ($ClienteModel->Deletar($id)) {
            response()->redirect('/Cliente/Listar');
        } else {
            response()->json(['error' => 'Erro ao deletar cliente'], 500);
        }
    }
}
