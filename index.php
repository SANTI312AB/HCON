<?php

use App\Kernel;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

// Esta línea detecta automáticamente dónde está el archivo y busca hacia adelante
require __DIR__.'/config/bootstrap.php'; 

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
    Debug::enable();
} else {
    \Symfony\Component\VarDumper\VarDumper::setHandler(function($var) {});
}

// ... resto del código igual ...

$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);