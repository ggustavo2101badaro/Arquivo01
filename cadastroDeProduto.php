<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastroDeProduto.css">
    <title>Cadastrar Produto</title>
</head>
<body>
    <div class="container">
        <h1>Cadastrar Produto</h1>
        <form action="tabela.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea>

            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" step="0.01" min="0"  required>

            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" min="1"  oninput="this.value = this.value.slice(0,5)" required>

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
