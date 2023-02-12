<?php

declare(strict_types=1);

// Set classes autoload function
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
\Dotenv\Dotenv::createUnsafeImmutable(__DIR__)->load();

// Get request details
$method = $_SERVER["REQUEST_METHOD"];
$uri_parts = explode("/", $_SERVER["REQUEST_URI"]);

// Process request
$database = new Database();
$gateway = new ProductGateway($database);
$controller = new ProductController($gateway);
$controller->processRequest($method, $uri_parts);


