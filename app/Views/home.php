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
    <title>Home - Gestor Restaurante</title>
    <link rel="icon" type="image/x-icon" href="app/img/favicon.ico">
    <script type="text/javascript" src="js/script.js" defer></script>
</head>
<body>
        <div class="lista-previsoes">
            <div class="item-previsao">
                <p class="faturamento"><?= 'R$ ' . number_format($estoque->ingredientes()->getValorEstoque(), 2, ',') ?></p>
                <p style="text-align: center;">Valor de Estoque</p>
            </div>

            <div class="item-previsao">
                <p class="faturamento">R$ 0,00</p>
                <p style="text-align: center;">Faturamento</p>
            </div>
            <div class="item-previsao">
            <p class="lucro-liquido"><?= 'R$ ' . $estoque->vendas()->getLucroTotal() ?></p>
                <p style="text-align: center;">Lucro Atual</p>
            </div>
        </div> <!-- lista-previsoes -->

    <div class="container">
        <div class="estoque">
            <h2>Estoque</h2>
            <table class="table-estoque">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Peso (g)</th>
                        <th>Preço (Kg)</th>
                        <th>Valor Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php if(!empty($estoque->ingredientes()->getIngredientes())): ?>
                    <?php foreach($estoque->ingredientes()->getIngredientes() as $ingrediente):  ?>
                        <tr>
                            <td><?= $ingrediente['nome'] ?></td>
                            <td><?= $ingrediente['peso'] > 0 ? $ingrediente['peso'] : '-' ?></td>
                            <td><?= 'R$ ' . number_format($ingrediente['precokg'], 2, ',') ?></td>
                            <td><?= 'R$ ' . number_format($ingrediente['valor_atual'], 2, ',') ?></td>
                            <td><a href="javascript:excluirIngrediente(<?= $ingrediente['id'] ?>, '<?= $ingrediente['nome'] ?>')"><button class="botao-excluir">Excluir</button></a></td>
                        </tr>
                    <?php endforeach ?>
                <?php else: ?>
                        <tr>
                            <td><p> Não há nada no estoque </p></td>
                        </tr>
                <?php endif ?>
                </tbody>
            </table>
        </div> <!-- estoque -->

        <div class="produtos">
            <h2>Receitas</h2>
            <table class="table-produtos">
                <thead>
                    <tr>
                        <th>Prato</th>
                        <th>Preço</th>
                        <th>Lucro</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($estoque->pratos()->getPratos())): ?>
                        <?php foreach($estoque->pratos()->getPratos() as $prato): ?>
                            <tr>
                                <td><a href="javascript:mostrarPrato('<?= $prato['id'] ?>')"><?= $prato['nome'] ?></a></td>
                                <td><?= 'R$ ' . number_format($prato['preco'], 2, ',') ?></td>
                                <td><?= 'R$ ' . number_format($prato['lucro'], 2, ',') ?></td>
                                <td><a href="javascript:registrarVenda(<?= $prato['id'] ?>, '<?= $prato['nome'] ?>')"><button class="botao-registrar">Registrar Venda</button></a></td>
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
    </div> <!-- container -->
    
</body>
</html>
