<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Buki\Router\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;

$router = new Router([           
'paths' => [
    'controllers' => __DIR__ . '/../app/Controllers',
],
'namespaces' => [
    'controllers' => 'App\\Controllers',
],
]);

$router->get('/', 'App\Controllers\HomeController@index');
$router->get('/login', 'App\Controllers\AuthController@showLogin');


$router->run();