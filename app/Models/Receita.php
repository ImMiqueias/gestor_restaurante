<?php

namespace App\Models;
use App\Models\Database;

use PDO;
class Receita extends Database{
    private $lista_ingredientes;
    private $connection;
    
    public function __construct() {
        $this->connection = $this->connect();
    }

    public function inserirReceita($nome, $preco, $ingredientes) {
        $stmt = 'SELECT nome FROM pratos WHERE nome =:nome';
        $stmt = $this->connection->prepare($stmt);
        $stmt->bindParam(':nome', $nome);
        $stmt->execute();
        if (empty($stmt->fetchAll())) {
            $stmt = 'INSERT INTO pratos (nome, preco, ingredientes) VALUES (:nome, :preco, :ingredientes)';
            $stmt = $this->connection->prepare($stmt);
            try {
                $stmt->execute(array(
                    ':nome'         => $nome,
                    ':preco'         => $preco,
                    ':ingredientes' => $ingredientes
                ));
                echo "Receita inserida com sucesso!";
            }catch(PDOException $e) {
                echo "Erro ao inserir receita: " . $e->getMessage();
            }
        }
        else{
            echo "Receita já existe.";
        }
    }
    public function excluirReceita($id, $nome) {
        $stmt = 'SELECT id FROM pratos WHERE id = :id';
        $stmt = $this->connection->prepare($stmt);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if (!empty($stmt->fetchAll())) {
            $stmt = 'DELETE FROM pratos WHERE id = :id';
            $stmt = $this->connection->prepare($stmt);
            $stmt->bindParam(':id', $id);
            try {
                $stmt->execute();
                echo "Receita " . $nome . " excluída";
            }catch(PDOException $e) {
                echo "Falha ao excluir receita: " . $e->getMessage();
            }
        }
        else {
            echo "Receita não encontrada";
        }
    }
}