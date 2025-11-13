<?php

namespace App\Controllers;

class GeminiController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = getenv('GEMINI_API_KEY') ?: env('GEMINI_API_KEY', '');

        if (empty($this->apiKey)) {
            $this->apiKey = 'SUA_CHAVE_AQUI';
        }
    }

    public function gerarObservacaoCliente()
    {
        $dados = request()->body();

        $nome = $dados['nome'] ?? '';
        $cpf = $dados['cpf'] ?? '';
        $telefone = $dados['telefone'] ?? '';
        $email = $dados['email'] ?? '';
        $endereco = $dados['endereco'] ?? '';

        $prompt = "Gere uma observação profissional curta (máximo 2 linhas) sobre um cliente com os seguintes dados:\n";
        $prompt .= "Nome: $nome\n";
        if ($cpf) $prompt .= "CPF: $cpf\n";
        if ($telefone) $prompt .= "Telefone: $telefone\n";
        if ($email) $prompt .= "Email: $email\n";
        if ($endereco) $prompt .= "Endereço: $endereco\n";
        $prompt .= "\nA observação deve ser útil para um sistema de gestão de clientes.";

        $observacao = $this->chamarGemini($prompt);

        response()->json(['observacao' => $observacao]);
    }

    public function gerarObservacaoProduto()
    {
        $dados = request()->body();

        $nome = $dados['nome'] ?? '';
        $descricao = $dados['descricao'] ?? '';
        $preco = $dados['preco'] ?? '';
        $estoque = $dados['estoque'] ?? '';

        $prompt = "Gere uma observação técnica curta (máximo 2 linhas) sobre um produto com os seguintes dados:\n";
        $prompt .= "Nome: $nome\n";
        if ($descricao) $prompt .= "Descrição: $descricao\n";
        if ($preco) $prompt .= "Preço: R$ $preco\n";
        if ($estoque) $prompt .= "Estoque: $estoque unidades\n";
        $prompt .= "\nA observação deve ser útil para um sistema de gestão de produtos.";

        $observacao = $this->chamarGemini($prompt);

        response()->json(['observacao' => $observacao]);
    }

    private function chamarGemini($prompt)
    {
        if (empty($this->apiKey)) {
            return 'Erro: Chave da API não configurada.';
        }

        $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-lite:generateContent?key=' . $this->apiKey;

        $data = [
            'contents' => [
                [
                    'parts' => [
                        [
                            'text' => $prompt
                        ]
                    ]
                ]
            ]
        ];

        $jsonData = json_encode($data);

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return 'Erro cURL: ' . $curlError;
        }

        curl_close($ch);

        $responseData = json_decode($response, true);

        if ($httpCode == 200 && isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            return $responseData['candidates'][0]['content']['parts'][0]['text'];
        }

        if (isset($responseData['error']['message'])) {
            return 'Erro da API: ' . $responseData['error']['message'];
        }

        return 'Erro HTTP ' . $httpCode . ': ' . substr($response, 0, 200);
    }
}

