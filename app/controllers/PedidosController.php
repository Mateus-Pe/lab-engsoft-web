<?php

namespace App\Controllers;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Produto;

class PedidosController extends Controller
{
    public function index()
    {
        response()->render('pedido');
    }

    public function Cadastrar()
    {
        $ClienteModel = new Cliente();
        $ProdutoModel = new Produto();

        $Clientes = $ClienteModel->Listar();
        $Produtos = $ProdutoModel->Listar();

        response()->render('PedidoCadastrar', [
            'Clientes' => $Clientes,
            'Produtos' => $Produtos
        ]);
    }

    public function Salvar()
    {
        try {
            $dados = request()->body();
            $PedidoModel = new Pedido();

            if (empty($dados['cliente_id'])) {
                response()->json(['error' => 'Selecione um cliente'], 400);
                return;
            }

            $pedidoId = $PedidoModel->Criar($dados);

            if ($pedidoId && $pedidoId > 0) {
                if (isset($dados['produtos']) && is_array($dados['produtos'])) {
                    foreach ($dados['produtos'] as $item) {
                        if (!empty($item['produto_id']) && !empty($item['quantidade']) && !empty($item['preco_unitario'])) {
                            $PedidoModel->AdicionarItem(
                                $pedidoId,
                                $item['produto_id'],
                                $item['quantidade'],
                                $item['preco_unitario']
                            );
                        }
                    }
                }

                response()->redirect('/Pedido/Listar');
            } else {
                response()->json(['error' => 'Erro ao criar pedido no banco de dados'], 500);
            }
        } catch (\Exception $e) {
            response()->json(['error' => 'Erro: ' . $e->getMessage()], 500);
        }
    }

    public function Listar()
    {
        $PedidoModel = new Pedido();
        $Pedidos = $PedidoModel->Listar();

        response()->render('PedidoListar', ['Pedidos' => $Pedidos]);
    }

    public function Editar($id)
    {
        $PedidoModel = new Pedido();
        $ClienteModel = new Cliente();
        $ProdutoModel = new Produto();

        $Pedido = $PedidoModel->BuscarPorId($id);
        $Clientes = $ClienteModel->Listar();
        $Produtos = $ProdutoModel->Listar();
        $ItensPedido = $PedidoModel->BuscarItensDoPedido($id);

        if (!$Pedido) {
            response()->redirect('/Pedido/Listar');
            return;
        }

        response()->render('PedidoEditar', [
            'Pedido' => $Pedido,
            'Clientes' => $Clientes,
            'Produtos' => $Produtos,
            'ItensPedido' => $ItensPedido
        ]);
    }

    public function Atualizar($id)
    {
        try {
            $dados = request()->body();
            $PedidoModel = new Pedido();

            if ($PedidoModel->Atualizar($id, $dados)) {
                db()->delete('pedido_itens')->where('pedido_id', $id)->execute();

                if (isset($dados['produtos']) && is_array($dados['produtos'])) {
                    foreach ($dados['produtos'] as $item) {
                        if (!empty($item['produto_id']) && !empty($item['quantidade']) && !empty($item['preco_unitario'])) {
                            $PedidoModel->AdicionarItem(
                                $id,
                                $item['produto_id'],
                                $item['quantidade'],
                                $item['preco_unitario']
                            );
                        }
                    }
                }

                response()->redirect('/Pedido/Listar');
            } else {
                response()->json(['error' => 'Erro ao atualizar pedido'], 500);
            }
        } catch (\Exception $e) {
            response()->json(['error' => 'Erro: ' . $e->getMessage()], 500);
        }
    }

    public function Deletar($id)
    {
        $PedidoModel = new Pedido();

        if ($PedidoModel->Deletar($id)) {
            response()->redirect('/Pedido/Listar');
        } else {
            response()->json(['error' => 'Erro ao deletar pedido'], 500);
        }
    }
}
