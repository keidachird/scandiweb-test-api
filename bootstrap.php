<?php

require "vendor/autoload.php";

\Dotenv\Dotenv::createUnsafeImmutable(__DIR__)->load();

$database = new Database();
$conn = $database->getConnection();