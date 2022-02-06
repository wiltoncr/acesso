<?php


namespace Source\Core;

/**
 * Class Model
 * @package Source\Models
 */
abstract class Model
{
    /**
     * @var object|null
     **/
    protected $data;

    /**
     * @var \PDOException|null
     */
    protected $fail;

    /**
     * @var string|null
     */
    protected $message;

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (empty($this->data)) {
            $this->data = new \stdClass();
        }

        $this->data->$name = $value; /*jogando as propriedades novas para dentro de data*/
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data->$name); /*Verificando se tem essa propriedade dentro de data*/
    }

    /**
     * @param $name
     * @return |null
     */
    public function __get($name)
    {
        return ($this->data->$name ?? null); /*mudando o comportamento se a pesquisa for uma propr. que existe em data*/
    }

    /**
     * @return object|null
     */
    public function Data(): ?object
    {
        return $this->data;
    }

    /**
     * @return \PDOException
     */
    public function Fail(): ?\PDOException
    {
        return $this->fail;
    }

    /**
     * @return string|null
     */
    public function Message(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $entity
     * @param array $data
     * @return int|null
     */
    protected function create(string $entity, array $data): ?int
    {
        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $stmt = Connect::getInstance()->prepare("INSERT INTO {$entity} ({$columns}) VALUES ({$values})");
            $stmt->execute($this->filter($data)); /*Esse momento o filtro é aplicado*/

            return Connect::getInstance()->lastInsertId();

        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @param string $select
     * @param string|null $params
     * @return \PDOStatement|null
     */
    protected function read(string $select, string $params = null): ?\PDOStatement
    {
        try {
            $stmt = Connect::getInstance()->prepare($select);
            if ($params) {
                parse_str($params, $paramsA);
                foreach ($paramsA as $key => $value) {
                    $type = (is_numeric($value) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
                    $stmt->bindValue(":{$key}", $value, $type);
                }
            }

            $stmt->execute();
            return $stmt;

        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @param string $entity
     * @param array $data
     * @param string $terms
     * @param string $params
     * @return int|null
     */
    protected function update(string $entity, array $data, string $terms, string $params): ?int
    {
        try {
            $dateSet = [];
            foreach ($data as $bind => $value) {
                $dateSet[] = "{$bind} = :{$bind}";
            }
            $dateSet = implode(", ", $dateSet);
            parse_str($params, $params);

            $stmt = Connect::getInstance()->prepare("UPDATE {$entity} SET {$dateSet} WHERE {$terms}");
            $stmt->execute($this->filter(array_merge($data, $params)));
            return ($stmt->rowCount() ?? 1);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @param string $entity
     * @param string $terms
     * @param string $params
     * @return int|null
     */
    protected function delete(string $entity, string $terms, string $params): ?int
    {
        try {
            $stmt = Connect::getInstance()->prepare("DELETE FROM {$entity} WHERE {$terms}");
            parse_str($params, $paramsA);
            $stmt->execute($this->filter($paramsA));
            return ($stmt->rowCount() ?? 1);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @return array|null
     */
    protected function safe(): ?array
    {
        $safe = (array)$this->data;

        foreach (static::$safe as $unset) { /*Lá na class filha o que eu não posso tratar*/
            unset($safe[$unset]);       /*tirando o que não podemos tratar*/
        }

        return $safe;
    }

    /**
     * @param array $data
     * @return array
     */
    private function filter(array $data)
    {
        $filter = [];
        foreach ($data as $key => $value) { /*Essa função vai mudar o os caracter para quebrar script*/
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS));
        }
        return $filter;
    }

}