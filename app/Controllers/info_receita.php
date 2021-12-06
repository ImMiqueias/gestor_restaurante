<?php

use App\Models\Estoque;

$json = file_get_contents('php://input');
$data = json_decode($json);
$estoque = new Estoque;
$info = $estoque->pratos()->getPratos();
foreach($info as $row) {
    if($row['id'] == $data->id) {
        $info = $row;
        break;
    }
}

$ingredientes = explode(',', $info['ingredientes']);
echo "<p style='color:black'>Ingredientes</p><br>";
for($i=0; $i < count($ingredientes); $i += 2) {
    foreach($estoque->ingredientes()->getIngredientes() as $ingrediente) {
        if($ingrediente['id'] == $ingredientes[$i]) {
            echo "<p style='color:#636363'>";
            echo $ingrediente['nome'] . "<p>" . $ingredientes[$i+1] . "gramas</p><br>";
            echo "</p>";
        }
    }
    
}