<?php

namespace App\Models;
class IngredientesEstoque {
    private $lista_ingredientes = array();
    private $valor_estoque = 0;
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
        $this->buscarIngredientes();
    }
    public function buscarIngredientes() {
        $query = 'SELECT id, nome, peso, precokg FROM ingredientes';
        $query =  $this->connection->query($query);
        $array_ingredientes = $query->fetchAll();

        for($i = 0; $i < count($array_ingredientes); $i++) {
            $this->lista_ingredientes[$i]['id'] = $array_ingredientes[$i]['id'];
            $this->lista_ingredientes[$i]['nome'] = $array_ingredientes[$i]['nome'];
            $this->lista_ingredientes[$i]['peso'] = $array_ingredientes[$i]['peso'];
            $this->lista_ingredientes[$i]['precokg'] = $array_ingredientes[$i]['precokg'];
            $this->lista_ingredientes[$i]['valor_atual'] = $this->calculaValorAtual($array_ingredientes[$i]);
            $this->valor_estoque += $this->lista_ingredientes[$i]['valor_atual'];
        }
    }

    public function calculaValorAtual($ingrediente) {
        if ($ingrediente['peso'] > 0) {
            return $ingrediente['precokg'] * ($ingrediente['peso'] / 1000);
        }
    }

    public function getIngredientes() {
        return $this->lista_ingredientes;
    }

    public function getValorEstoque() {
        return $this->valor_estoque;
    }
}