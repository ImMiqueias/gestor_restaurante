<?php

use App\Models\Ingrediente;

$json = file_get_contents('php://input');
$data = json_decode($json);

(new Ingrediente)->excluirIngrediente($data->id, $data->nome);