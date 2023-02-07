<?php

class Database
{
    private PDO $conn;

    public function __construct()
    {
        $host = getenv("DB_HOST");
        $port = getenv("DB_PORT");
        $name = getenv("DB_NAME");
        $user = getenv("DB_USER");
        $password = getenv("DB_PASSWORD");

        $dsn = "mysql: host=$host; port=$port; dbname=$name; charset=utf8";

        $this->conn = new PDO($dsn, $user, $password, [
                PDO::ATTR_STRINGIFY_FETCHES => false,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }
}