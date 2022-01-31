<?php

namespace Src\Database;

use Exception;
use PDO;
use PDOException;
use PDOStatement;

class Connect
{    
    protected const HOST = "localhost";
    protected const PORT = "3306";
    protected const DB_NAME = "acesso";
    protected const DB_USER = "root";
    protected const DB_PASS = "";

    protected function connect()
    {
        try {
            $conn = new PDO('mysql:host=' . self::HOST . ';port=' . self::PORT . ';dbname='. self::DB_NAME, self::DB_USER, self::DB_PASS);
            echo "Tudo certo com o banco de dados";
        } catch (PDOException $e){
            echo "Erro: Erro ao conectar ao banco de dados";
            return false;
        }
    }

}
