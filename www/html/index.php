<?php
require_once './vendor/autoload.php';
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use App\Controllers\CustomerController;

$routes = new RouteCollection();

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

$request = new Request();

$routes->add('customer_index', new Route(
  '/customer',
    ['_controller' => [new CustomerController(), 'index']],
    [],
    [],
    '',
    [],
    ['GET']
));


$routes->add('customer_create', new Route(
  '/customer',
    ['_controller' => [new CustomerController(), 'create']],
    [],
    [],
    '',
    [],
    ['POST']
));

$routes->add('customer_update', new Route(
  '/customer', [
    '_controller' => [new CustomerController(), 'update']],
    [],
    [],
    '',
    [],
    ['PUT']
));

$routes->add('customer_delete', new Route(
  '/customer', [
  '_controller' => [new CustomerController(), 'delete']],
  [],
  [],
  '',
  [],
  ['DELETE']
));

$request = Request::createFromGlobals();

$matcher = new UrlMatcher($routes, new RequestContext());

$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();


$kernel = new HttpKernel($dispatcher, $controllerResolver, new RequestStack(), $argumentResolver);

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);