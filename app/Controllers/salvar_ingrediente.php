<?php

use App\Models\Ingrediente;

$json = file_get_contents('php://input');
$data = json_decode($json);

(new Ingrediente)->inserirIngrediente($data->nome, $data->peso, $data->preco_kg);