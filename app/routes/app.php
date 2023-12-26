<?php

use App\Controllers\ExampleController;
use Peppux\Route;

$route = new Route;

$route->method('GET')->controller(ExampleController::class)->add('/', 'index');
$route->method('GET')->controller(ExampleController::class)->add('/example', 'index');
$route->method('GET')->controller(ExampleController::class)->add('/example/{id}/{a12}', 'show');
$route->method('GET')->controller(ExampleController::class)->add('/example/{id}', 'show');
$route->method('GET')->controller(ExampleController::class)->add('/example/{id}/name/{name}', 'show');
