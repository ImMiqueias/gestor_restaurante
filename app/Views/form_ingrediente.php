<?php include 'header.php' ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="js/script.js" defer></script>
    <title>Formulário Ingrediente - Gestor Restaurante</title>
</head>
<body>
    <div class="form-container">
        <h1>Inserir/Atualizar Ingrediente</h1>
    
        <div class="form-div">
            <form enctype="multipart/form-data" name="form-ingrediente" method="POST" action="javascript:addIngrediente()">

                <span>Nome do Ingrediente</span>
                <input type="text" id="nome" name="nome" placeholder="Nome do Ingrediente" maxlength="18" required>
                <span>Peso (g)</span>
                <input type="number" id="peso" name="peso" placeholder="Peso (g)" required>
                <span>Preço (Kg)</span>
                <input type="number" id="preco_kg" name="preco_kg" placeholder="Preço (Kg)" step="0.01" required>
                <input class="submit" type="submit" value="Enviar">
            </form>
        </div>
        <div class="message-container" id="message-container">
        </div>
    </div>
</body>
</html>
