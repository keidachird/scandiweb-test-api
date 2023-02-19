<?php

class Database
{
    private ?PDO $conn = null;

    public function __construct(
        private readonly string $host,
        private readonly string $name,
        private readonly string $user,
        private readonly string $password,
    ) {
    }

    public function getConnection(): PDO
    {
        if ($this->conn === null) {
            $dsn = "mysql:host=eu-cdbr-west-03.cleardb.net;dbname=heroku_784ca88e6d20f21;charset=utf8";

            $this->conn = new PDO($dsn, "bef553e2bd40da", "c5615c8e", [
                    PDO::ATTR_STRINGIFY_FETCHES => false,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        }
        return $this->conn;
    }
}