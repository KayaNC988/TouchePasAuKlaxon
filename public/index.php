<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Buki\Router\Router;
use App\Controllers\AdminController;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\TrajetController;


$router = new Router([           
'paths' => [
    'controllers' => __DIR__ . '/../app/Controllers',
],
'namespaces' => [
    'controllers' => 'App\\Controllers',
],
   'debug' => true,
]);

$router->get('/', 'App\Controllers\HomeController@index');
$router->get('/login', 'App\Controllers\AuthController@showLogin');
$router->post('/login', 'App\Controllers\AuthController@Login');
$router->get('/logout', 'App\Controllers\AuthController@logout');
$router->get('/trajets/create', 'App\Controllers\TrajetController@create');
$router->post('/trajets', [TrajetController::class, 'store']);
$router->get('/trajets/:id', 'App\Controllers\TrajetController@show');
$router->get('/trajets/:id/edit', 'App\Controllers\TrajetController@edit');
$router->post('/trajets/:id/edit', 'App\Controllers\TrajetController@update');
$router->post('/trajets/:id/delete', [TrajetController::class, 'delete']);

// Routes administrateur
$router->get('/admin/users', [AdminController::class, 'users']);

$router->get('/admin/agences', [AdminController::class, 'agences']);
$router->get('/admin/agences/create', [AdminController::class, 'createAgence']);
$router->post('/admin/agences', [AdminController::class, 'storeAgence']);
$router->get('/admin/agences/:id/edit', [AdminController::class, 'editAgence']);
$router->post('/admin/agences/:id/edit', [AdminController::class, 'updateAgence']);
$router->post('/admin/agences/:id/delete', [AdminController::class, 'deleteAgence']);

$router->get('/admin/trajets', [AdminController::class, 'trajets']);
$router->post('/admin/trajets/:id/delete', [AdminController::class, 'deleteTrajet']);

$router->run();