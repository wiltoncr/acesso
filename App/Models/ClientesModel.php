<?php
declare(strict_types = 1);
namespace App\Models;

use Core\Model;

class ClientesModel extends Model
{ 

    private $table = '';
    private $require = ['nome', 'email'];

    /**
     * Get the value of require
     */ 
    public function getRequire()
    {
        return $this->require;
    }

    /**
     * Onde o model é criado. Uma conexão com o banco de dados é aberta.
     */
    function __construct($table)
    {
        $this->table = $table;
        parent::__construct($this->table);
    }

    public function add($result)
    {
        try {
        $sql = "INSERT INTO clientes (nome, email) VALUES (:nome, :email)";
        $query = $this->pdo->prepare($sql);
        $parameters = array(':nome' => $result['nome'], ':email' => $result['email']);

        $query->execute($parameters);
        }catch (\PDOException $e) {
        echo "Erro no banco de dados" . $e->getMessage() . " ";
        die();
        }catch (\Exception $e) {
        echo "Erro no sistema" . $e->getMessage() . " ";
        die();
        }
    }

    public function umReg($field_id)
    {
        $result = $this->select('id=:id', ['id' => $field_id],"*",1);
        return $result->fetch();
    }

    public function filterName($search)
    {
        $result = $this->select('nome like :nome', ['nome' => "%$search%"]);
        return $result;
    }

    public function filterRegs(string $search)
    {
        $result = $this->select(
            'id like :id or nome like :nome or email like :email',
            ['id' => "%$search%", 'nome' => "%$search%", 'email' => "%$search%"]
        );
        return $result->fetchAll();
    }

    public function update($result)
    {
        $sql = 'UPDATE clientes SET nome = :nome, email = :email WHERE id = :field_id';
        $query = $this->pdo->prepare($sql);
        $parameters = array(':nome' => $result['nome'], ':email' => $result['email'], ':field_id' => $result['field_id']);

        $query->execute($parameters);
    }
}
