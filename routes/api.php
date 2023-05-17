<?php

use App\Controllers\Api\ExampleController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();


$routes->add('', new Route(
    '/{task_id}',
    ['_controller' => [new ExampleController, 'show']],
    ['task_id' => '[0-9]+'],
    [],
    '',
    [],
    ['GET'],
));

$routes->add('/', new Route(
    '/',
    ['_controller' => [new ExampleController, 'store']],
    ['arguments'],
    [],
    '',
    [],
    ['POST'],
));

return $routes;