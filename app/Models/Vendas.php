<?php

namespace App\Models;
use App\Models\Database;
use PDO;

class Vendas extends Database {

    private $connection = 0;


    public function __construct() {
        $this->connection = $this->connect();
    }

    public function getLucroTotal() {
        $result = 0;
        $sql = 'SELECT lucro FROM vendas';
        $stmt = $this->connection->query($sql);
        
        foreach($stmt as $row)
            $result += $row['lucro'];

        return $result;
    }
}