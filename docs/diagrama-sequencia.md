# Diagramas de Sequência - Proteus ERP

## 1. Criar Cliente

```mermaid
sequenceDiagram
    actor Usuario
    participant View as ClienteCadastrar.blade
    participant Router as LeafRouter
    participant Controller as ClientesController
    participant Model as Cliente
    participant DB as LeafDB (SQLite)
    participant IA as GeminiController

    Usuario->>View: Preenche formulário
    Usuario->>View: Clica em "Gerar com IA"
    View->>IA: POST /api/gemini/cliente
    IA->>IA: chamarGemini(prompt)
    IA-->>View: JSON {observacao}
    View->>View: Preenche campo observações
    
    Usuario->>View: Clica em "Salvar"
    View->>Router: POST /Cliente/Salvar
    Router->>Controller: Salvar()
    Controller->>Controller: Valida dados
    Controller->>Model: Criar(dados)
    Model->>DB: INSERT INTO clientes
    DB-->>Model: Success
    Model-->>Controller: true
    Controller->>Router: redirect('/Cliente/Listar')
    Router->>Controller: Listar()
    Controller->>Model: Listar()
    Model->>DB: SELECT * FROM clientes
    DB-->>Model: array de clientes
    Model-->>Controller: array
    Controller->>View: render('ClienteListar')
    View-->>Usuario: Exibe lista atualizada
```

## 2. Criar Pedido com Itens

```mermaid
sequenceDiagram
    actor Usuario
    participant View as PedidoCadastrar.blade
    participant JS as JavaScript
    participant Router as LeafRouter
    participant Controller as PedidosController
    participant PedidoModel as Pedido
    participant ClienteModel as Cliente
    participant ProdutoModel as Produto
    participant DB as LeafDB (SQLite)

    Usuario->>View: Acessa /Pedido/Cadastrar
    View->>Router: GET /Pedido/Cadastrar
    Router->>Controller: Cadastrar()
    Controller->>ClienteModel: Listar()
    ClienteModel->>DB: SELECT * FROM clientes
    DB-->>ClienteModel: clientes[]
    Controller->>ProdutoModel: Listar()
    ProdutoModel->>DB: SELECT * FROM produtos
    DB-->>ProdutoModel: produtos[]
    Controller->>View: render('PedidoCadastrar', data)
    View-->>Usuario: Exibe formulário

    Usuario->>JS: Adiciona produto
    JS->>JS: adicionarProduto()
    JS->>JS: atualizarPreco()
    JS->>JS: calcularSubtotal()
    JS->>JS: calcularTotal()
    JS-->>Usuario: Atualiza interface

    Usuario->>View: Clica em "Salvar Pedido"
    View->>Router: POST /Pedido/Salvar
    Router->>Controller: Salvar()
    
    Controller->>Controller: Valida cliente_id
    
    Note over Controller,DB: Inicia transação implícita
    
    Controller->>PedidoModel: Criar(dados)
    PedidoModel->>DB: INSERT INTO pedidos
    PedidoModel->>DB: SELECT MAX(id) FROM pedidos
    DB-->>PedidoModel: pedido_id
    PedidoModel-->>Controller: pedido_id

    loop Para cada produto
        Controller->>PedidoModel: AdicionarItem(pedido_id, produto_id, qtd, preco)
        PedidoModel->>DB: INSERT INTO pedido_itens
        DB-->>PedidoModel: Success
    end

    Note over Controller,DB: Commit transação
    
    Controller->>Router: redirect('/Pedido/Listar')
    Router->>View: PedidoListar
    View-->>Usuario: Lista de pedidos atualizada
```

## 3. Editar Pedido

```mermaid
sequenceDiagram
    actor Usuario
    participant View as PedidoEditar.blade
    participant Router as LeafRouter
    participant Controller as PedidosController
    participant PedidoModel as Pedido
    participant ClienteModel as Cliente
    participant ProdutoModel as Produto
    participant DB as LeafDB (SQLite)

    Usuario->>View: Clica em "Editar" no pedido
    View->>Router: GET /Pedido/Editar/{id}
    Router->>Controller: Editar(id)
    
    Controller->>PedidoModel: BuscarPorId(id)
    PedidoModel->>DB: SELECT pedidos JOIN clientes WHERE id={id}
    DB-->>PedidoModel: pedido
    
    Controller->>ClienteModel: Listar()
    ClienteModel->>DB: SELECT * FROM clientes
    DB-->>ClienteModel: clientes[]
    
    Controller->>ProdutoModel: Listar()
    ProdutoModel->>DB: SELECT * FROM produtos
    DB-->>ProdutoModel: produtos[]
    
    Controller->>PedidoModel: BuscarItensDoPedido(id)
    PedidoModel->>DB: SELECT pedido_itens JOIN produtos WHERE pedido_id={id}
    DB-->>PedidoModel: itens[]
    
    Controller->>View: render('PedidoEditar', data)
    View-->>Usuario: Exibe formulário preenchido

    Usuario->>View: Modifica dados
    Usuario->>View: Clica em "Atualizar"
    View->>Router: POST /Pedido/Atualizar/{id}
    Router->>Controller: Atualizar(id)
    
    Controller->>PedidoModel: Atualizar(id, dados)
    PedidoModel->>DB: UPDATE pedidos SET ... WHERE id={id}
    DB-->>PedidoModel: Success
    
    Controller->>DB: DELETE FROM pedido_itens WHERE pedido_id={id}
    DB-->>Controller: Success
    
    loop Para cada produto
        Controller->>PedidoModel: AdicionarItem(id, produto_id, qtd, preco)
        PedidoModel->>DB: INSERT INTO pedido_itens
    end
    
    Controller->>Router: redirect('/Pedido/Listar')
    View-->>Usuario: Lista atualizada
```

## 4. Deletar Cliente

```mermaid
sequenceDiagram
    actor Usuario
    participant View as ClienteListar.blade
    participant Router as LeafRouter
    participant Controller as ClientesController
    participant Model as Cliente
    participant DB as LeafDB (SQLite)

    Usuario->>View: Clica em "Deletar"
    View->>View: confirm("Deseja deletar?")
    Usuario->>View: Confirma
    View->>Router: POST /Cliente/Deletar/{id}
    Router->>Controller: Deletar(id)
    Controller->>Model: Deletar(id)
    Model->>DB: DELETE FROM clientes WHERE id={id}
    DB-->>Model: Success
    Model-->>Controller: true
    Controller->>Router: redirect('/Cliente/Listar')
    Router->>Controller: Listar()
    Controller->>Model: Listar()
    Model->>DB: SELECT * FROM clientes
    DB-->>Model: clientes[]
    Model-->>Controller: array
    Controller->>View: render('ClienteListar')
    View-->>Usuario: Lista atualizada (cliente removido)
```

## 5. Gerar Observação com IA (Gemini)

```mermaid
sequenceDiagram
    actor Usuario
    participant View as ClienteCadastrar.blade
    participant JS as JavaScript (Frontend)
    participant Router as LeafRouter
    participant Controller as GeminiController
    participant API as Google Gemini API

    Usuario->>View: Preenche campos do formulário
    Usuario->>View: Clica em "Gerar com IA"
    View->>JS: onclick gerarObservacao()
    JS->>JS: Coleta dados do formulário
    JS->>JS: Valida campo nome
    
    JS->>Router: fetch POST /api/gemini/cliente
    Note over JS,Router: JSON: {nome, cpf, telefone, email, endereco}
    
    Router->>Controller: gerarObservacaoCliente()
    Controller->>Controller: Valida dados
    Controller->>Controller: Monta prompt
    Note over Controller: "Gere observação sobre cliente..."
    
    Controller->>Controller: chamarGemini(prompt)
    Controller->>API: POST https://generativelanguage.googleapis.com/v1beta/...
    Note over Controller,API: Headers: Content-Type: application/json<br/>Body: {contents: [{parts: [{text}]}]}
    
    API->>API: Processa com modelo gemini-2.0-flash-lite
    API-->>Controller: JSON Response
    Note over API,Controller: {candidates: [{content: {parts: [{text}]}}]}
    
    Controller->>Controller: Extrai texto da resposta
    Controller-->>Router: JSON {observacao: "texto gerado"}
    Router-->>JS: Response JSON
    
    JS->>JS: Valida resposta
    JS->>View: Preenche textarea observações
    View-->>Usuario: Exibe observação gerada
```

## 6. Dashboard (Carregamento Inicial)

```mermaid
sequenceDiagram
    actor Usuario
    participant Browser
    participant Router as LeafRouter
    participant View as dashboard.blade
    participant ClienteModel as Cliente
    participant ProdutoModel as Produto
    participant PedidoModel as Pedido
    participant DB as LeafDB (SQLite)

    Usuario->>Browser: Acessa /
    Browser->>Router: GET /
    Router->>View: render('index')
    
    Note over View: @hasSection('content') = false
    View->>View: @include('dashboard')
    
    View->>ClienteModel: new Cliente()
    ClienteModel->>DB: PRAGMA journal_mode = WAL
    ClienteModel->>DB: CREATE TABLE IF NOT EXISTS clientes
    View->>ClienteModel: Contar()
    ClienteModel->>DB: SELECT COUNT(*) FROM clientes
    DB-->>ClienteModel: totalClientes
    
    View->>ProdutoModel: new Produto()
    ProdutoModel->>DB: PRAGMA journal_mode = WAL
    ProdutoModel->>DB: CREATE TABLE IF NOT EXISTS produtos
    View->>ProdutoModel: Contar()
    ProdutoModel->>DB: SELECT COUNT(*) FROM produtos
    DB-->>ProdutoModel: totalProdutos
    
    View->>PedidoModel: new Pedido()
    PedidoModel->>DB: PRAGMA journal_mode = WAL
    PedidoModel->>DB: CREATE TABLE IF NOT EXISTS pedidos
    View->>PedidoModel: Contar()
    PedidoModel->>DB: SELECT COUNT(*) FROM pedidos
    DB-->>PedidoModel: totalPedidos
    
    View->>PedidoModel: SomarTotal()
    PedidoModel->>DB: SELECT SUM(total) FROM pedidos
    DB-->>PedidoModel: faturamentoTotal
    
    View->>View: Renderiza cards com dados
    View-->>Browser: HTML renderizado
    Browser-->>Usuario: Exibe Dashboard com estatísticas
```

## Notas sobre SQLite

- **WAL Mode**: Ativado em todos os models para permitir leituras simultâneas
- **Busy Timeout**: 5000ms para aguardar lock liberação
- **Transações**: Gerenciadas automaticamente pelo LeafDB
- **Connection Pooling**: Cada Model cria sua própria conexão

## Padrões Identificados

1. **MVC Pattern**: Separação clara entre Models, Views e Controllers
2. **RESTful Routes**: Uso de convenções REST (GET, POST)
3. **Repository Pattern**: Models atuam como repositórios de dados
4. **Blade Templating**: Engine de templates para views
5. **AJAX**: Comunicação assíncrona para API Gemini
6. **Query Builder**: LeafDB abstrai SQL nativo

