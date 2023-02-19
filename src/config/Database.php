<?php

class Database
{
    private ?PDO $conn = null;

    public function __construct(
        private readonly string $host,
        private readonly string $port,
        private readonly string $name,
        private readonly string $user,
        private readonly string $password,
    ) {
    }

    public function getConnection(): PDO
    {
        if ($this->conn === null) {
            $dsn = "mysql: host=$this->host; port=$this->port; dbname=$this->name; charset=utf8";

            $this->conn = new PDO($dsn, $this->user, $this->password, [
                    PDO::ATTR_STRINGIFY_FETCHES => false,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        }
        return $this->conn;
    }
}