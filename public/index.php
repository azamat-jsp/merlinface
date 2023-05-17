<?php

require __DIR__ . '/../vendor/autoload.php';

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
$routes = include __DIR__.'/../routes/api.php';

$context = new \Symfony\Component\Routing\RequestContext();
$matcher = new \Symfony\Component\Routing\Matcher\UrlMatcher($routes, $context);

$controllerResolver = new \Symfony\Component\HttpKernel\Controller\ControllerResolver();
$argumentResolver = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver();

$framework = new App\Kernel($matcher, $controllerResolver, $argumentResolver);
$response = $framework->handle($request);

$response->send();