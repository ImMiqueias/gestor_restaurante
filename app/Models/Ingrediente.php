<?php

namespace App\Models;
use App\Models\Database;

use PDO;
class Ingrediente extends Database{
    private $lista_ingredientes;
    private $connection;
    
    public function __construct() {
        $this->connection = $this->connect();
    }

    public function inserirIngrediente($nome, $peso, $preco_kg) {
        $stmt = 'SELECT nome FROM ingredientes WHERE nome =:nome';
        $stmt = $this->connection->prepare($stmt);
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        if (empty($stmt->fetchAll())) {
            $stmt = 'INSERT INTO ingredientes (nome, peso, precokg) VALUES (:nome, :peso, :precokg)';
            $stmt = $this->connection->prepare($stmt);
            try {
                $stmt->execute(array(
                    ':nome' => $nome,
                    ':peso' => $peso,
                    ':precokg' => $preco_kg
                ));
                echo "Ingrediente inserido com sucesso!";
            }catch(PDOException $e) {
                echo "Erro ao inserir ingrediente: " . $e->getMessage();
            }
        }
        else{
            $this->atualizarIngrediente($nome, $peso, $preco_kg);
        }
    }
    public function atualizarIngrediente($nome, $peso, $preco_kg) {
        $stmt = 'UPDATE ingredientes SET peso = :peso, precokg = :precokg WHERE nome = :nome';
        $stmt = $this->connection->prepare($stmt);
        try {
                $stmt->execute(array(
                    ':nome' => $nome,
                    ':peso' => $peso,
                    ':precokg' => $preco_kg
                ));
                echo "Ingrediente atualizado com sucesso!";
        }catch(PDOException $e) {
            echo "Erro ao atualizar ingrediente: " . $e->getMessage();
        }
    }
    public function excluirIngrediente($id, $nome) {
        $stmt = 'SELECT id FROM ingredientes WHERE id = :id';
        $stmt = $this->connection->prepare($stmt);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if (!empty($stmt->fetchAll())) {
            if($this->verificaLigacoesComReceitas($id)) {
                echo "Existem receitas ligadas à esse ingrediente";
                return;
            }
            $stmt = 'DELETE FROM ingredientes WHERE id = :id';
            $stmt = $this->connection->prepare($stmt);
            $stmt->bindParam(':id', $id);
            try {
                $stmt->execute();
                echo "Ingrediente " . $nome . " Excluído.";
            }catch(PDOException $e) {
                echo "Falha ao excluir ingrediente: " . $e->getMessage();
            }
        }
        else {
            echo "Ingrediente não encontrado.";
        }
    }
    private function verificaLigacoesComReceitas($id) {
        $stmt = 'SELECT ingredientes FROM pratos';
        $stmt = $this->connection->query($stmt);

        foreach($stmt as $row) {
            if($row['ingredientes'] > 0) {
                $ingredientes = explode(',', $row['ingredientes']);
                for($i = 0; $i < sizeof($ingredientes); $i += 2) 
                    if($ingredientes[$i] == $id) return true;
            }
        }
        return false;
    }

}