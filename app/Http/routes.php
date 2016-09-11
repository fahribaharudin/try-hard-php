<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

$routes = new RouteCollection;

$routes->add('landing_page', new Route('/', [
	'_controller' => function() {
		return new Response('Welcome, this is a boilerplate for try hard php project!');
	}
]));

$routes->add('hello', new Route('hello/{name}', [
	'_controller' => 'App\Http\Controllers\HelloController::sayHello'
]));

return $routes;