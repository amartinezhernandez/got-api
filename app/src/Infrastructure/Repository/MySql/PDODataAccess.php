<?php

namespace App\Infrastructure\Repository\MySql;

use Exception;
use PDO;
use PDOException;

class PDODataAccess
{
    protected string $dsn;
    protected string $username;
    protected string $password;
    protected ?PDO $pdo;

    public function __construct(string $dsn, string $username = "", string $password = "")
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->pdo = null;
    }

    public function __call($name, array $arguments)
    {
        try {
            $this->connection()->query("SHOW STATUS;")->execute();
        } catch (PDOException $e) {
            if ($e->getCode() != 'HY000' || !stristr($e->getMessage(), 'server has gone away')) {
                throw $e;
            }

            $this->reconnect();
        }

        return call_user_func_array(array($this->connection(), $name), $arguments);
    }

    protected function connection()
    {
        return $this->pdo !== null ? $this->pdo : $this->connect();
    }

    public function connect()
    {
        $this->pdo = new PDO($this->dsn, $this->username, $this->password, []);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $this->pdo;
    }

    public function reconnect()
    {
        $this->close();
        return $this->connect();
    }

    public function pdo()
    {
        return $this->pdo;
    }

    public function query(string $sqlToPrepare, array $parameters = [], bool $singleResult = false, bool $column = false): array
    {
        $this->connection();
        $query = $this->pdo->prepare($sqlToPrepare);
        $this->bindParams($query, $parameters);

        if ($singleResult === true) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
        } elseif ($column === true) {
            $data = $query->fetchAll(PDO::FETCH_COLUMN);
        } else {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }

    public function insert(string $sqlToPrepare, array $parameters = []): int
    {
        $this->connection();
        $query = $this->pdo->prepare($sqlToPrepare);
        $this->bindParams($query, $parameters);

        return $this->pdo->lastInsertId();
    }

    public function updateOrDelete($sqlToPrepare, $parameters = [])
    {
        $this->connection();
        $query = $this->pdo->prepare($sqlToPrepare);
        $this->bindParams($query, $parameters);
        return $query->rowCount() > 0;
    }

    private function getParamType($value): int
    {
        $type = 0;

        if (is_numeric($value) && ctype_digit($value)) {
            $type = PDO::PARAM_INT;
        }
        if (!ctype_digit($value)) {
            $type = PDO::PARAM_STR;
        }

        return $type;
    }

    private function bindParams($query, $parameters)
    {
        if (count($parameters) > 0) {
            foreach ($parameters as $key => $value) {
                $castValue = $this->simpleCast($value);
                $paramType = $this->getParamType($value);
                $query->bindParam($key, $castValue, $paramType);
                $parameters[$key] = $castValue;
            }
        }
        return $query->execute($parameters);
    }

    public function close(): void
    {
        $this->pdo = null;
    }

    /**
     * When this function is called and passed as an argument for a function
     * that expects an argument by reference can cause errors on php ^7.2
     * Just return its value by reference to solve it.
     *
     * @param  $value
     * @return float|int|null|string
     */
    public function &simpleCast($value)
    {
        if ($value === null || $value === true || $value === false) {
            return $value;
        }

        if (is_numeric($value) && intval($value) != $value) {
            $return = floatval($value);
            return $return;
        }

        if (is_string($value) && !ctype_digit($value)) {
            $return = $value;
            return $return;
        }

        if (ctype_digit($value) || $value == intval($value)) {
            $return = intval($value);
            return $return;
        }

        return $value;
    }
}
