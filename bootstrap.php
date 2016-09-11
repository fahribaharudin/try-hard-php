<?php 

// auto loader
require 'vendor/autoload.php';

// init whoops error handler
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// config function helper
function config($name) {
    $config = require 'config.php';

    return $config[$name];
}

// boot the http kernel
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$routes     = require 'app/Http/routes.php';

$request    = Request::createFromGlobals();
$matcher    = new UrlMatcher($routes, new RequestContext);

$dispatcher = new EventDispatcher;
$dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack));

$controllerResolver = new ControllerResolver;
$argumentResolver   = new ArgumentResolver;

$kernel     = new HttpKernel($dispatcher, $controllerResolver, new RequestStack, $argumentResolver);

$response   = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);