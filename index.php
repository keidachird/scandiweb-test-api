<?php

declare(strict_types=1);

spl_autoload_register(function ($class) {
    if (__DIR__ . "/src/config/$class.php") {
        require __DIR__ . "/src/config/$class.php";
    }
});
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

header("Content-type: application/json; charset=UTF-8");

require "bootstrap.php";

if ($conn) {
    echo "Connected successfully";
}

