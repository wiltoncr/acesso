<?php

namespace App\Models;

use Core\Model;
use Exception;
use PDO;
use PDOException;

class AcessoModel extends Model
{
    private $table = '';

    private $require = ['acesso', 'tipo_acesso', 'id_cliente', 'apelido'];

    /**
     * Get the value of require
     */ 
    public function getRequire()
    {
        return $this->require;
    }

    public function __construct($table)
    {
        $this->table = $table;
        parent::__construct($this->table);
    } 
    
    public function add($result)
    {
        try {
            $sql = "INSERT INTO acesso (acesso, apelido, tipo_acesso, id_cliente) VALUES (:acesso, :apelido, :tipo_acesso, :id_cliente)";
            $query = $this->pdo->prepare($sql);
            $parameters = array(":acesso" => $result['acesso'], ":apelido" => $result['apelido'], ":tipo_acesso" => $result['tipo_acesso'], ":id_cliente" => $result['id_cliente']);
            $query->execute($parameters);
        }catch (PDOException $e) {
            echo "Erro no banco de dados" . $e->getMessage() . " ";
            die();
        }catch (Exception $e) {
            echo "Erro no sistema" . $e->getMessage() . " ";
            die();
        }
        
    }

    public function umReg($field_id)
    {
        $result = $this->select('id=:id', ['id' => $field_id],"*",1);
        return $result->fetch();
    }

    public function filterRegs(string $search)
    {
        $clientes = (new ClientesModel("clientes"))->filterRegs($search);
        $idClientes = [];

        foreach ($clientes as $value) {
            $idClientes[] = $value->id;
        }
        
        $idClientes = (!empty($idClientes))?  "or id_cliente in (" . implode(",", $idClientes) . ")": "";

        $result = $this->select(
            "id like :id or acesso like :acesso or tipo_acesso like :tipo_acesso or apelido like :apelido ". $idClientes,
            ['id' => "%$search%", 'acesso' => "%$search%", 'tipo_acesso' => "%$search%", 'apelido' => "%$search%"]
        );
        return $result->fetchAll();
    }

    public function update($result)
    {   /**refatorar os parametros de requisicao da tablela */
        try {
        $sql = 'UPDATE acesso SET acesso = :acesso, apelido = :apelido, tipo_acesso = :tipo_acesso, id_cliente = :id_cliente WHERE id = :field_id';
        $query = $this->pdo->prepare($sql);
        $parameters = array(":acesso" => $result['acesso'], ":apelido" => $result['apelido'], ":tipo_acesso" => $result['tipo_acesso'], ":id_cliente" => $result['id_cliente'], ":field_id" => $result['field_id']);
        $query->execute($parameters);
        
        }catch (PDOException $e) {
        echo "Erro no banco de dados" . $e->getMessage() . " ";
        die();
        }catch (Exception $e) {
        echo "Erro no sistema" . $e->getMessage() . " ";
        die();
        }
    }
}