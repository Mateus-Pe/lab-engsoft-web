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
        response()->view('ClienteCadastrar');
    }

    public function Salvar()
    {

    }

    public function Listar()
    {
       $ClienteModel = new Cliente();
       $Clientes = $ClienteModel->Listar();

       response()->render('ClienteListar', ['Clientes' => $Clientes]);
    }

    public function Deletar($id)
    {

    }
}
