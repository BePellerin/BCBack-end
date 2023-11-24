<?php

use App\Kernel;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
header("Allow: *");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "OPTIONS") {
    header("HTTP/1.1 200 OK");
    exit;
}

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
