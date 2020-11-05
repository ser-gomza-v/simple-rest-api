<?php

use Faker\Factory;
use SimpleRest\Controller\GoodsController;
use SimpleRest\Controller\OrdersController;
use SimpleRest\Service\Goods;
use SimpleRest\Service\Orders;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$containerBuilder = new ContainerBuilder();
$faker = Factory::create();

$containerBuilder->set('entityManager', require_once 'doctrine.php');
$containerBuilder->set('faker', $faker);
$containerBuilder->register('service.orders', Orders::class)->addArgument($containerBuilder->get('entityManager'));
$containerBuilder->register('service.goods', Goods::class)
    ->addArgument($containerBuilder->get('entityManager'))
    ->addArgument($containerBuilder->get('faker'));
$containerBuilder->register('controller.orders', OrdersController::class)->addArgument(new Reference('service.orders'));
$containerBuilder->register('controller.goods', GoodsController::class)->addArgument(new Reference('service.goods'));

return $containerBuilder;