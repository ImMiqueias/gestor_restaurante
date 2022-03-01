<?php

namespace App\Models;
use App\Models\{Database, PratosEstoque, IngredientesEstoque, Vendas};
use PDO;

class Estoque extends Database {
    private $connection;

    private $lucro_liquido_estoque;
    private $obj_ingredientes;
    private $obj_pratos;
    private $obj_vendas;
    public function __construct() {
        $this->connection = $this->connect();
        $this->obj_ingredientes = new IngredientesEstoque($this->connection);
        $this->obj_pratos = new PratosEstoque($this->connection);
        $this->obj_vendas = new Vendas();
        
        $this->lucro_liquido_estoque = $this->obj_pratos->getLucro();
    }
    public function ingredientes() {
        return $this->obj_ingredientes;
    }
    public function pratos() {
        return $this->obj_pratos;
    }
    public function vendas() {
        return $this->obj_vendas;
    }
    // Função para calcular quantidade de pratos possíveis de serem feitos
    // com os ingredientes disponíveis no estoque.
    public function iteraReceitas() {}

    public function registrarVenda($prato_id) {
        $prato = array();
        $estoque_ingredientes = $this->ingredientes()->getIngredientes();

        
        foreach($this->pratos()->getPratos() as $row) {
            if($row['id'] == $prato_id) {
                $prato = $row;
                // Dados a serem registrador na tabela "vendas"
                $venda = [
                    'prato' => $row['nome'],
                    'lucro' => $row['lucro']
                ];
                break;
            }
        }
        
        if(empty($prato)) return;

        $ingredientes = explode(',', $prato['ingredientes']);

        
        for($i = 0; $i < sizeof($ingredientes); $i += 2) {
            foreach($estoque_ingredientes as $row) {
                if($row['id'] == $ingredientes[$i]) {
                    if($row['peso'] < $ingredientes[$i+1]) {
                        echo "<p class='error-msg'>Não há ingredientes para isso.</p>";
                        return;
                    }
                    $novo_peso_ingredientes[] = $row['peso'] - $ingredientes[$i+1];
                    $id_ingredientes[] = $ingredientes[$i];
                }
            }
        }

        $sql = 'UPDATE ingredientes SET peso = ? WHERE id = ?';
        $stmt = $this->connection->prepare($sql);

        for($i = 0; $i < sizeof($id_ingredientes); $i++) {
            
            try {
                $stmt->execute(array($novo_peso_ingredientes[$i], $id_ingredientes[$i]));
            }catch(PDOException $e) {
                echo "Erro ao executar query: " . $e->getMessage();
                return;
            }
        }
        $assign = $this->assinarVenda($venda);
        echo "Venda registrada." . $assign;

    }
    // Função para registrar a venda na tabela "vendas"
    private function assinarVenda(array $vendas) {
        $sql = 'INSERT INTO vendas (prato, lucro) VALUES (:prato, :lucro)';
        $stmt = $this->connection->prepare($sql);

        try {
            $stmt->execute(array(
                ':prato' => $vendas['prato'],
                ':lucro' => $vendas['lucro']
            ));
            echo "Registrado na database.";
        } catch(PDOException $e) {
            echo "<p class='error-msg'>Não registrado na database.</p>";
        }
    }
}