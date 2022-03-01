<?php

namespace App\Models;
use PDO;
class PratosEstoque {

    private $custo_pratos = 0;
    private $faturamento_estoque = 0;
    private $lucro_estoque = 0;

    private $lista_pratos = array();

    public function __construct($connection) {
        $this->buscarPratos($connection);
    }

    public function buscarPratos($connection) {
        $query = 'SELECT id, nome, preco, ingredientes FROM pratos';
        $query =  $connection->query($query);
        $array_pratos = $query->fetchAll();
        for($i=0; $i < count($array_pratos); $i++) {
            $this->lista_pratos[$i]['id'] = $array_pratos[$i]['id'];
            $this->lista_pratos[$i]['nome'] = $array_pratos[$i]['nome'];
            $this->lista_pratos[$i]['preco'] = $array_pratos[$i]['preco'];
            $this->lista_pratos[$i]['lucro'] = $this->calculaLucro($array_pratos[$i]['id'], $connection);
            $this->lista_pratos[$i]['ingredientes'] = $array_pratos[$i]['ingredientes'];
        }
    }

    public function calculaLucro($id_prato, $connection) {
        $stmt = 'SELECT preco, ingredientes FROM pratos WHERE id =:id_prato';
        $stmt = $connection->prepare($stmt);
        $stmt->bindParam(':id_prato', $id_prato, PDO::PARAM_INT);
        $stmt->execute();
        $id_ingredientes = array();
        $qtd_ingredientes = array();
        $preco_prato = 0;
        $custo = 0;
        foreach($stmt as $row) {
            if($row['ingredientes'] > 0) {
                $ingredientes = explode(',', $row['ingredientes']);
                for($i=0;$i<sizeof($ingredientes);$i+=2) {
                    $id_ingredientes[] = $ingredientes[$i];
                    $qtd_ingredientes[$ingredientes[$i]] = $ingredientes[$i+1];
                }
                $preco_prato = $row['preco'];
            }
        }
        $place_holders = implode(',', array_fill(0, count($id_ingredientes), '?'));
        $stmt = "SELECT id, precokg FROM ingredientes WHERE id IN ($place_holders) ORDER BY id ASC";
        $stmt = $connection->prepare($stmt);
        $stmt->execute($id_ingredientes);
        $ingredientes = $stmt->fetchAll();
        foreach($ingredientes as $ingrediente) {
            $custo += $ingrediente["precokg"] * ($qtd_ingredientes[$ingrediente["id"]] / 1000);
        }
        $this->custo_pratos += $custo;
        $this->faturamento_estoque += $preco_prato;
        $this->lucro_estoque += ($preco_prato - $custo);
        return $this->lucro_estoque;
    }
    
    public function getPratos() {
        return $this->lista_pratos;
    }

    public function getFaturamento() {
        return $this->faturamento_estoque;
    }
    
    public function getLucro() {
        return $this->lucro_estoque;
    }
}