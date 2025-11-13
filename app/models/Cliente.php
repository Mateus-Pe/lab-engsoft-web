<?php

namespace App\Models;

class Cliente extends Model
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
            CREATE TABLE IF NOT EXISTS clientes (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                cpf TEXT NOT NULL,
                telefone TEXT,
                email TEXT,
                endereco TEXT,
                observacoes TEXT,
                criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ")->execute();
    }

    public function Listar()
    {
        return db()->select('clientes')->all();
    }

    public function Contar(){
        return db()->query("SELECT COUNT(*) AS total FROM clientes")->first()['total'] ?? 0;
    }

    public function Criar($dados)
    {
        return db()->insert('clientes')->params([
            'nome' => $dados['nome'],
            'cpf' => $dados['cpf'],
            'telefone' => $dados['telefone'] ?? '',
            'email' => $dados['email'] ?? '',
            'endereco' => $dados['endereco'] ?? '',
            'observacoes' => $dados['observacoes'] ?? ''
        ])->execute();
    }

    public function BuscarPorId($id)
    {
        return db()->select('clientes')->where('id', $id)->first();
    }

    public function Atualizar($id, $dados)
    {
        return db()->update('clientes')
            ->params([
                'nome' => $dados['nome'],
                'cpf' => $dados['cpf'],
                'telefone' => $dados['telefone'] ?? '',
                'email' => $dados['email'] ?? '',
                'endereco' => $dados['endereco'] ?? '',
                'observacoes' => $dados['observacoes'] ?? ''
            ])
            ->where('id', $id)
            ->execute();
    }

    public function Deletar($id)
    {
        return db()->delete('clientes')->where('id', $id)->execute();
    }
}
