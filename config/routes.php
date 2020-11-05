<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;


$containerBuilder = require_once 'container.php';

$routes = new RouteCollection();

$routes->add(
    'goods',
    new Route(
        '/api/goods/{page?}/{count?}',
        [
            'controller' => $containerBuilder->get('controller.goods'),
            'method' => 'all'
        ],
        [
            'page' => '\d*',
            'count' => '\d*'
        ],
        [],
        '',
        'Http',
        'Get'
    )
);

$routes->add(
    'generate',
    new Route(
        '/api/generate',
        [
            'controller' => $containerBuilder->get('controller.goods'),
            'method' => 'generate'
        ],
        [],
        [],
        '',
        'Http',
        'Get'
    )
);

$routes->add(
    'orders',
    new Route(
        '/api/orders/{page?}/{count?}',
        [
            'controller' => $containerBuilder->get('controller.orders'),
            'method' => 'all'
        ],
        [
            'page' => '\d*',
            'count' => '\d*'
        ],
        [],
        '',
        'Http',
        'Get'
    )
);

$routes->add(
    'make',
    new Route(
        '/api/make_order',
        [
            'controller' => $containerBuilder->get('controller.orders'),
            'method' => 'make'
        ],
        [],
        [],
        '',
        'Http',
        'Post'
    )
);

$routes->add(
    'pay',
    new Route(
        '/api/pay_order',
        [
            'controller' => $containerBuilder->get('controller.orders'),
            'method' => 'pay'
        ],
        [],
        [],
        '',
        'Http',
        'Post'
    )
);

return $routes;