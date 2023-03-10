<?php

declare(strict_types=1);

require __DIR__ . "/vendor/autoload.php";

use App\{Database, ProductGateway, ProductController};
use Dotenv\Dotenv;

// Set error and exception handler functions
set_error_handler("App\ErrorHandler::handleError");
set_exception_handler("App\ErrorHandler::handleException");

// Set headers
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-type");

// Disable environment variables for heroku
//$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
//$dotenv->load();

// Get request details
$method = $_SERVER["REQUEST_METHOD"];
$uri = explode("/", $_SERVER["REQUEST_URI"]);

// Process request
$database = new Database(
    getenv("DB_HOST"),
    getenv("DB_PORT"),
    getenv("DB_NAME"),
    getenv("DB_USER"),
    getenv("DB_PASSWORD")
);
$gateway = new ProductGateway($database);
$controller = new ProductController($gateway);
$controller->processRequest($method, $uri);

//var_dump(get_included_files());


