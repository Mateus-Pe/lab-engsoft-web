<?php

namespace App\Models;

class Produto extends Model
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
            CREATE TABLE IF NOT EXISTS produtos (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                descricao TEXT,
                preco REAL NOT NULL DEFAULT 0,
                estoque INTEGER DEFAULT 0,
                criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ")->execute();
    }

    public function Listar()
    {
        return db()->select('produtos')->all();
    }

    public function Contar()
    {
        return db()->query("SELECT COUNT(*) AS total FROM produtos")->first()['total'] ?? 0;
    }

    public function Criar($dados)
    {
        return db()->insert('produtos')->params([
            'nome' => $dados['nome'],
            'descricao' => $dados['descricao'] ?? '',
            'preco' => $dados['preco'],
            'estoque' => $dados['estoque'] ?? 0
        ])->execute();
    }

    public function BuscarPorId($id)
    {
        return db()->select('produtos')->where('id', $id)->first();
    }

    public function Atualizar($id, $dados)
    {
        return db()->update('produtos')
            ->params([
                'nome' => $dados['nome'],
                'descricao' => $dados['descricao'] ?? '',
                'preco' => $dados['preco'],
                'estoque' => $dados['estoque'] ?? 0
            ])
            ->where('id', $id)
            ->execute();
    }

    public function Deletar($id)
    {
        return db()->delete('produtos')->where('id', $id)->execute();
    }
}
