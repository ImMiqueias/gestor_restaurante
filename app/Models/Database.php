<?php

namespace App\Models;
use PDO;
class Database {

    protected function connect($file = 'app/config/database.ini') {
        if (!$settings = parse_ini_file($file, true))
            throw new Exception("Impossível carregar arquivo" . $file . ".");
        $dsn = $settings['database']['driver'] . 
                ':host=' . $settings['database']['host'] . 
                ';dbname=' . $settings['database']['schema'];
        $attr = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try {
            $connection = new PDO($dsn, $settings['database']['username'], '', $attr);
        } catch(PDOException $e) {
            echo "Impossível conectar ao banco de dados: " . $e->getMessage();
        }
        return $connection;
    }
}