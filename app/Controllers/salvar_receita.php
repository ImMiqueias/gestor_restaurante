<?php
use App\Models\Receita;

$json = file_get_contents('php://input');
$data = json_decode($json);

(new Receita)->inserirReceita($data->nome, $data->preco, $data->ingredientes);