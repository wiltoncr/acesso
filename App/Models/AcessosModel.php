<?php

namespace App\Controllers;

use Core\Model;

class AcessosModel extends Model
{
    private $table = '';

    public function __construct($table)
    {
        $this->table = $table;
        parent::__construct($this->table);
    } 
    
    public function add($params)
    {
        $sql = "INSERT INTO acesso (acesso, tipo_acesso, id_cliente) VALUES (:acesso, :tipo_acesso, :id_cliente)";
        $query = $this->pdo->prepare($sql);
        $parameters = array(":acesso" => $params['acesso'], ":tipo_acesso" => $params['tipo_acesso'], ":id_cliente" => $params['id_cliente']);

        $query->execute($parameters);
    }

    public function umReg($field_id)
    {
        $sql = 'SELECT id, nome, email FROM clientes WHERE id = :field_id LIMIT 1';
        $query = $this->pdo->prepare($sql);
        $parameters = array(':field_id' => $field_id);

        $query->execute($parameters);

        // fetch() é o método PDO que recebe exatamento um único resultado/registro
        return ($query->rowcount() ? $query->fetch() : false);
    }

    public function update($nome, $email, $field_id)
    {
        $sql = 'UPDATE clientes SET nome = :nome, email = :email WHERE id = :field_id';
        $query = $this->pdo->prepare($sql);
        $parameters = array(':nome' => $nome, ':email' => $email, ':field_id' => $field_id);

        $query->execute($parameters);
    }

}
