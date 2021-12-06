<?php
use App\Models\Estoque;

$json = file_get_contents('php://input');
$data = json_decode($json);

(new Estoque)->registrarVenda($data->id);