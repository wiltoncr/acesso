<?php
declare(strict_types = 1);
namespace Core;

use Exception;
use PDOException;

class Model extends Connection
{

    private $table = '';


    function __construct($table)
    {
        $this->table = $table;
        try {
            self::openDb();
        } catch ( \PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    // Número de campos da tabela atual
    public function numFields(){
        $sql = 'SELECT * FROM '.$this->table.' LIMIT 1';
        $sth = $this->pdo->query($sql);
        $num_campos = $sth->columnCount();
        return $num_campos;
    }

    // Nome de campo pelo número $x
    public function fieldName($x){
        $sql = 'SELECT * FROM '.$this->table.' LIMIT 1';
        $sth = $this->pdo->query($sql);
        $meta = $sth->getColumnMeta($x);
        $field = $meta['name'];
        return $field;
    }

    public function fields(){
        $fld = '';
        for($x=1;$x < $this->numFields();$x++){
            $field = $this->fieldName($x);
            if($x < $this->numFields()-1){
              $fld .= $field.','; 
            }else{
              $fld .= $field; 
            }
		    }
        $fld = explode(',', $fld);
        return $fld;
    }

    public function class($sufix){
      $class = ucfirst($this->table).$sufix."('$this->table')";
      return $class;
    }    

    // Agora este três métodos abaixo não são criados sempre que se cria um novo crud, mas apenas herdados pelos novos models
    public function todosRegs()
    {
        
        $this->select();
        $sql = 'SELECT * FROM '.$this->table.' ORDER BY id';
//print $sql;exit;
        $query = $this->pdo->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function delete($field_id)
    {
        try {
        $sql = 'DELETE FROM '.$this->table.' WHERE id = :field_id';
        $query = $this->pdo->prepare($sql);
        $parameters = array(':field_id' => $field_id);

        $query->execute($parameters);
        }catch (PDOException $e) {
            echo (new ErrorController())->index(3,"Verifique se não existe Acesso para esse cliente");
            die();
        }catch (Exception $e) {
            echo (new ErrorController())->index(3,"Erro interno, por favor entre em contato com o suporte");
            die();
        }
    }

    public function somaRegs()
    {
        $sql = 'SELECT COUNT(id) AS soma FROM '.$this->table;
        $query = $this->pdo->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->soma;
    }

    public function listRegs($colums = '*')
    {
        return  $this->select("", [], $colums);
    }

    protected function select(string $terms = '' , array $params = [], string $colums = '*', int $limit = 100)
    {
        try{
            if(!empty($terms) && !empty($params)){
                $sql = 'SELECT '. $colums . ' FROM '. $this->table . ' WHERE ' . $terms . " LIMIT ". $limit;
                $query = $this->pdo->prepare($sql);
                foreach ($params as $key => $value){
                    $query->bindValue(":".$key, $value);
                }
            }else {
                $sql = 'SELECT '. $colums . ' FROM '. $this->table;
                $query = $this->pdo->prepare($sql);
            }
            $query->execute();
            return $query;
        }catch (PDOException $e) {
            echo (new ErrorController())->index(3,"Verifique os parametros");
            die();
        }catch (Exception $e) {
            echo (new ErrorController())->index(3,"Erro interno, por favor entre em contato com o suporte");
            die();
        }
    }
}
