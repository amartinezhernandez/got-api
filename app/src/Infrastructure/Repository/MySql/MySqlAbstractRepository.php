<?php

namespace App\Infrastructure\Repository\MySql;

abstract class MySqlAbstractRepository
{
    protected PDODataAccess $pdo;

    public function __construct(PDODataAccess $pdo)
    {
        $this->pdo = $pdo;
    }

    protected function buildIdParameters(array &$parameters, int ...$ids): void
    {
        array_walk($ids, function ($id, $key) use (&$parameters) {
            $parameters[":id{$key}"] = $id;
        });
    }
}