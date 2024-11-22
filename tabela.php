<?php
// Carregar produtos do arquivo JSON ou inicializar vazio
 $arquivo = 'produtos.json';
$produtos = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];

// Processar o formulário enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $preco = floatval($_POST['preco']);
    $quantidade = intval($_POST['quantidade']);

    // Adicionar o novo produto
    $novoProduto = [
        'id' => uniqid(),
        'nome' => $nome,
        'descricao' => $descricao,
        'preco' => $preco,
        'quantidade' => $quantidade,
    ];
    $produtos[] = $novoProduto;

    // Salvar no arquivo JSON
   file_put_contents($arquivo, json_encode($produtos, JSON_PRETTY_PRINT));
}

// Ações de edição ou exclusão
if (isset($_GET['acao']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($_GET['acao'] === 'excluir') {
        // Excluir produto
        $produtos = array_filter($produtos, fn($produto) => $produto['id'] !== $id);
    } elseif ($_GET['acao'] === 'editar' && $_POST) {
        // Editar produto
        foreach ($produtos as &$produto) {
            if ($produto['id'] === $id) {
                $produto['nome'] = trim($_POST['nome']);
                $produto['descricao'] = trim($_POST['descricao']);
                $produto['preco'] = floatval($_POST['preco']);
                $produto['quantidade'] = intval($_POST['quantidade']);
            }
        }
    }

    // Salvar no arquivo JSON
   file_put_contents($arquivo, json_encode($produtos, JSON_PRETTY_PRINT));
}

// Renderizar página com produtos
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tabela.css">
    <title>Produtos Cadastrados</title>
</head>
<body>
    <div class="container">
        <h1>Produto Cadastrado</h1>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?= htmlspecialchars($produto['nome']) ?></td>
                        <td><textarea cols="20" rows="10"><?= htmlspecialchars($produto['descricao']) ?></textarea></td>
                        <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                        <td><?= $produto['quantidade'] ?></td>
                        <td>
                            <form action="?acao=editar&id=<?= $produto['id'] ?>" method="POST" class="alterarDados">
                               <h3>Editar:</h3>

<div class="alteraEditar">
                               <table >
                                <tr>
                                    <td>  <label>Nome:</label></td>
                                    <td> <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required></td>
                                </tr>
                                <tr>
                                    <td> <label>Descrição:</label></td>
                                    <td> <input type="text" name="descricao" value="<?= htmlspecialchars($produto['descricao']) ?>" required></td>
                                </tr>
                                <tr>
                                    <td> <label>Preço:</label></td>
                                    <td> <input type="number" name="preco" value="<?= $produto['preco'] ?>" step="0.01" required><br></td>
                                </tr>
                                <tr>
                                    <td> <label>Quantidade:</label></td>
                                    <td> <input type="number" name="quantidade" value="<?= $produto['quantidade'] ?>" required></td>
                                </tr>
                               </table>
                               </div>
                                <button type="submit" class="salvar">SALVAR</button>
                            </form>
                            <br>
                            <a href="?acao=excluir&id=<?= $produto['id'] ?>" class="delete">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="http://localhost/outro-teste-php/cadastroDeProduto.php" class="add">Cadastrar Novo Produto</a>
    </div>
</body>
</html>
