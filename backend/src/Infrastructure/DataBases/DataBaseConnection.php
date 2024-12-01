<?php

namespace App\Infrastructure\DataBases;

use PDO;

class DataBaseConnection
{
    private string $host = 'mysql';
    private string $dbName = 'cadastro-desenvolvedores';
    private string $user = 'vitor';
    private string $pass = 'senha1';

    public function getConnection(): PDO
    {
        return new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->user, $this->pass);
    }
}