<?php 
    include 'header.php';
    $estoque = new App\Models\Estoque;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="js/script.js" defer></script>

    <title>Gerenciar Receitas - Gestor Restaurante</title>
</head>
<body>
    <div class="form-container" style="margin-top: 200px;">
        <div class="produtos">
            <table class="table-produtos">
                <thead>
                    <tr>
                        <th>Prato</th>
                        <th>Preço</th>
                        <th>Lucro</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($estoque->pratos()->getPratos())): ?>
                        <?php foreach($estoque->pratos()->getPratos() as $prato): ?>
                            <tr>
                                <td><a href="javascript:mostrarPrato('<?= $prato['id'] ?>')"><?= $prato['nome'] ?></a></td>
                                <td><?= 'R$ ' . number_format($prato['preco'], 2, ',') ?></td>
                                <td><?= 'R$ ' . $prato['lucro'] ?></td>
                                <td><a href="javascript:excluirReceita(<?= $prato['id'] ?>, '<?= $prato['nome'] ?>')"><button class="botao-excluir">Excluir Receita</button></a></td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td><p> Não há receitas </p></td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div> <!-- produtos -->
    </div>
</body>
</html>