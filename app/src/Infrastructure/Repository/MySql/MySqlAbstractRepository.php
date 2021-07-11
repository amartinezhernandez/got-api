<?php

namespace App\Infrastructure\Repository\MySql;

abstract class MySqlAbstractRepository
{
    protected PDODataAccess $pdo;

    public function __construct(PDODataAccess $pdo)
    {
        $this->pdo = $pdo;
    }
}