<?php 
    include 'header.php';
    $estoque = new App\Models\Estoque;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="js/script.js" defer></script>

    <title>Formulário Receita - Gestor Restaurante</title>
</head>
<body>
    <div class="form-container">
        <form name="inserir-receita" method="POST" enctype="multipart/form-data" action="javascript:addReceita()">
            <div class="lista-receita">
                <h2>Inserir Receita</h2>
                <input id="nome" type="text" name="nome" placeholder="Nome da Receita" maxlength="32" required>
                <input id="preco" type="number" name="preco" placeholder="Preço" step='0.01' required>
            </div>
            <div class="lista-receita">
                <h2>Ingredientes</h2>
                <?php if(!empty($estoque->ingredientes()->getIngredientes())): ?>
                    <?php foreach($estoque->ingredientes()->getIngredientes() as $ingrediente): ?>
                        <div id="ingrediente-receita" class="ingrediente-receita">
                            <input class="opcao-check" id="<?= $ingrediente["id"] ?>" type="checkbox">
                            <label for="<?= $ingrediente["id"] ?>"><?= $ingrediente["nome"] ?></label>
                            <input class="opcao-qtd" id="<?= $ingrediente["id"] ?>" type="number" placeholder="Quantidade (g)" disabled required>
                        </div>
                    <?php endforeach ?>
                <?php else: ?>
                    <p style="color:red">Não há ingredientes !</p>
                <?php endif ?>
                <input class="submit" type="submit" value="Enviar">
                <div id="message-container" class="message-container">
                </div>
            </div>
        </form>
    </div>
</body>
</html>