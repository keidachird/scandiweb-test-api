<?php

declare(strict_types=1);

// Set autoload function for classes
// TODO rewrite in composer.json psr-4 format
spl_autoload_register(function ($class) {
    if (file_exists(__DIR__ . "/src/config/$class.php")) {
        require __DIR__ . "/src/config/$class.php";
    }

    if (file_exists(__DIR__ . "/src/controllers/$class.php")) {
        require __DIR__ . "/src/controllers/$class.php";
    }

    if (file_exists(__DIR__ . "/src/models/$class.php")) {
        require __DIR__ . "/src/models/$class.php";
    }
});

// Set error and exception handler functions
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

// Set headers
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type");

// Enable environment variables
require "vendor/autoload.php";
$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

// Get request details
$method = $_SERVER["REQUEST_METHOD"];
$uri = explode("/", $_SERVER["REQUEST_URI"]);

// Process request
$database = new Database($_ENV["DB_HOST"], $_ENV["DB_PORT"], $_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"]);
$gateway = new ProductGateway($database);
$controller = new ProductController($gateway);
$controller->processRequest($method, $uri);


