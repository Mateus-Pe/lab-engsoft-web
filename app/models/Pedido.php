<?php

namespace App\Models;

class Pedido extends Model
{
    public function __construct()
    {
        $dbFile = 'osfacil.db';
        if (!file_exists($dbFile)) {
            file_put_contents($dbFile, '');
        }

        db()->connect([
            'dbtype' => 'sqlite',
            'dbname' => $dbFile,
        ]);

        db()->query("PRAGMA journal_mode = WAL")->execute();
        db()->query("PRAGMA busy_timeout = 5000")->execute();

        db()->query("
            CREATE TABLE IF NOT EXISTS pedidos (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                cliente_id INTEGER NOT NULL,
                data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
                total REAL DEFAULT 0,
                status TEXT DEFAULT 'Pendente'
            )
        ")->execute();

        db()->query("
            CREATE TABLE IF NOT EXISTS pedido_itens (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                pedido_id INTEGER NOT NULL,
                produto_id INTEGER NOT NULL,
                quantidade INTEGER NOT NULL,
                preco_unitario REAL NOT NULL
            )
        ")->execute();
    }

    public function Listar()
    {
        return db()->query("
            SELECT p.*, c.nome as cliente_nome
            FROM pedidos p
            LEFT JOIN clientes c ON p.cliente_id = c.id
            ORDER BY p.data_pedido DESC
        ")->all();
    }

    public function Contar()
    {
        return db()->query("SELECT COUNT(*) AS total FROM pedidos")->first()['total'] ?? 0;
    }

    public function SomarTotal()
    {
        return db()->query("SELECT SUM(total) AS soma FROM pedidos")->first()['soma'] ?? 0;
    }

    public function Criar($dados)
    {
        try {
            $cliente_id = intval($dados['cliente_id']);
            $total = floatval($dados['total'] ?? 0);
            $status = $dados['status'] ?? 'Pendente';

            db()->query("INSERT INTO pedidos (cliente_id, total, status) VALUES ($cliente_id, $total, '$status')")->execute();

            $result = db()->query("SELECT MAX(id) as id FROM pedidos")->first();

            if ($result && isset($result['id']) && $result['id'] > 0) {
                return (int)$result['id'];
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function BuscarPorId($id)
    {
        $id = intval($id);

        return db()->query("
            SELECT p.*, c.nome as cliente_nome
            FROM pedidos p
            LEFT JOIN clientes c ON p.cliente_id = c.id
            WHERE p.id = $id
        ")->first();
    }

    public function BuscarItensDoPedido($pedido_id)
    {
        return db()->query("
            SELECT pi.*, pr.nome as produto_nome
            FROM pedido_itens pi
            LEFT JOIN produtos pr ON pi.produto_id = pr.id
            WHERE pi.pedido_id = ?
        ", [$pedido_id])->all();
    }

    public function Atualizar($id, $dados)
    {
        return db()->update('pedidos')
            ->params([
                'cliente_id' => $dados['cliente_id'],
                'total' => $dados['total'] ?? 0,
                'status' => $dados['status'] ?? 'Pendente'
            ])
            ->where('id', $id)
            ->execute();
    }

    public function Deletar($id)
    {
        db()->delete('pedido_itens')->where('pedido_id', $id)->execute();
        return db()->delete('pedidos')->where('id', $id)->execute();
    }

    public function AdicionarItem($pedido_id, $produto_id, $quantidade, $preco_unitario)
    {
        try {
            $pedido_id = intval($pedido_id);
            $produto_id = intval($produto_id);
            $quantidade = intval($quantidade);
            $preco_unitario = floatval($preco_unitario);

            db()->query(
                "INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, preco_unitario)
                 VALUES ($pedido_id, $produto_id, $quantidade, $preco_unitario)"
            )->execute();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function RemoverItem($item_id)
    {
        return db()->delete('pedido_itens')->where('id', $item_id)->execute();
    }
}
